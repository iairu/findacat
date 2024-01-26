<?php

namespace Tests\Unit;

use App\Couple;
use App\Cat;
use App\CatMetadata;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Nonstandard\Uuid;
use Tests\TestCase;

class CatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cat_have_profile_link()
    {
        $cat = factory(Cat::class)->create();
        $this->assertEquals(link_to_route('cats.show', $cat->nickname, [$cat->id]), $cat->profileLink());
    }

    /** @test */
    public function cat_can_have_many_couples()
    {
        $husband = factory(Cat::class)->states('male')->create();
        $wife = factory(Cat::class)->states('female')->create();
        $husband->addWife($wife);

        $husband = $husband->fresh();
        $this->assertCount(1, $husband->wifes);
        $this->assertCount(1, $wife->husbands);
        $this->assertCount(1, $husband->couples);
    }

    /** @test */
    public function cat_can_have_many_marriages()
    {
        $husband = factory(Cat::class)->states('male')->create();
        $wife = factory(Cat::class)->states('female')->create();
        $husband->addWife($wife);

        $husband = $husband->fresh();
        $this->assertCount(1, $husband->marriages);

        $wife = $wife->fresh();
        $this->assertCount(1, $wife->marriages);
    }

    /** @test */
    public function male_person_marriages_ordered_by_marriage_date()
    {
        $husband = factory(Cat::class)->states('male')->create();
        $wife1 = factory(Cat::class)->states('female')->create();
        $wife2 = factory(Cat::class)->states('female')->create();
        $husband->addWife($wife2, '1999-04-21');
        $husband->addWife($wife1, '1990-02-13');

        $husband = $husband->fresh();
        $marriages = $husband->marriages;
        $this->assertEquals('1990-02-13', $marriages->first()->marriage_date);
        $this->assertEquals('1999-04-21', $marriages->last()->marriage_date);

        $this->assertEquals($wife1->name, $husband->couples->first()->name);
        $this->assertEquals($wife2->name, $husband->couples->last()->name);

        $this->assertEquals($wife1->name, $husband->wifes->first()->name);
        $this->assertEquals($wife2->name, $husband->wifes->last()->name);
    }

    /** @test */
    public function female_person_marriages_ordered_by_marriage_date()
    {
        $wife = factory(Cat::class)->states('female')->create();
        $husband1 = factory(Cat::class)->states('male')->create();
        $husband2 = factory(Cat::class)->states('male')->create();
        $wife->addHusband($husband2, '1989-04-21');
        $wife->addHusband($husband1, '1980-02-13');

        $wife = $wife->fresh();
        $marriages = $wife->marriages;
        $this->assertEquals('1980-02-13', $marriages->first()->marriage_date);
        $this->assertEquals('1989-04-21', $marriages->last()->marriage_date);

        $this->assertEquals($husband1->name, $wife->couples->first()->name);
        $this->assertEquals($husband2->name, $wife->couples->last()->name);

        $this->assertEquals($husband1->name, $wife->husbands->first()->name);
        $this->assertEquals($husband2->name, $wife->husbands->last()->name);
    }

    /** @test */
    public function cat_can_ony_marry_same_person_once()
    {
        $husband = factory(Cat::class)->states('male')->create();
        $wife = factory(Cat::class)->states('female')->create();

        $husband->addWife($wife);

        $this->assertFalse($wife->addHusband($husband), 'This couple is married!');
    }

    /** @test */
    public function cat_have_father_link_method()
    {
        $father = factory(Cat::class)->create();
        $cat = factory(Cat::class)->create(['father_id' => $father->id]);

        $this->assertEquals($father->profileLink(), $cat->fatherLink());
    }

    /** @test */
    public function a_cat_has_many_metadata_relation()
    {
        $cat = factory(Cat::class)->create();
        $metadata = factory(CatMetadata::class)->create(['cat_id' => $cat->id]);

        $this->assertInstanceOf(Collection::class, $cat->metadata);
        $this->assertInstanceOf(CatMetadata::class, $cat->metadata->first());
    }

    /** @test */
    public function cat_model_has_get_metadata_method()
    {
        $cat = factory(Cat::class)->create();

        $this->assertNull($cat->getMetadata('cemetery_location_address'));

        DB::table('cat_metadata')->insert([
            'id'      => Uuid::uuid4()->toString(),
            'cat_id' => $cat->id,
            'key'     => 'cemetery_location_address',
            'value'   => 'Some address',
        ]);
        $cat = $cat->fresh();

        $this->assertEquals('Some address', $cat->getMetadata('cemetery_location_address'));
    }

    /** @test */
    public function cat_model_get_metadata_method_returns_all_metadata_if_key_is_null()
    {
        $cat = factory(Cat::class)->create();

        $this->assertEmpty($cat->getMetadata());

        DB::table('cat_metadata')->insert([
            'id'      => Uuid::uuid4()->toString(),
            'cat_id' => $cat->id,
            'key'     => 'cemetery_location_address',
            'value'   => 'Some address',
        ]);
        $cat = $cat->fresh();

        $this->assertCount(1, $cat->getMetadata());
    }

    /** @test */
    public function cat_model_get_metadata_method_accepts_a_default_value()
    {
        $cat = factory(Cat::class)->create();

        $this->assertEquals('Default value', $cat->getMetadata('some_missing_key', 'Default value'));

        DB::table('cat_metadata')->insert([
            'id'      => Uuid::uuid4()->toString(),
            'cat_id' => $cat->id,
            'key'     => 'some_missing_key',
            'value'   => 'Some value',
        ]);
        $cat = $cat->fresh();

        $this->assertEquals('Some value', $cat->getMetadata('some_missing_key', 'Default value'));
    }

    /** @test */
    public function cat_have_mother_link_method()
    {
        $mother = factory(Cat::class)->create();
        $cat = factory(Cat::class)->create(['mother_id' => $mother->id]);

        $this->assertEquals($mother->profileLink(), $cat->motherLink());
    }

    /** @test */
    public function a_cat_has_many_managed_couples_relation()
    {
        $cat = factory(Cat::class)->create();
        $managedCouple = factory(Couple::class)->create([]);

        $this->assertInstanceOf(Collection::class, $cat->managedCouples);
        $this->assertInstanceOf(Couple::class, $cat->managedCouples->first());
    }

    /**
     * @test
     * @dataProvider catAgeDataProvider
     */
    public function cat_has_age_attribute($today, $dob, $age)
    {
        Carbon::setTestNow($today);
        $cat = factory(Cat::class)->make([
            'dob' => $dob
        ]);

        $this->assertEquals($age, $cat->age);

        Carbon::setTestNow();
    }

    /**
     * @test
     * @dataProvider catAgeDetailDataProvider
     */
    public function cat_has_age_detail_attribute($today, $dob, $age)
    {
        Carbon::setTestNow($today);
        $cat = factory(Cat::class)->make([
            'dob' => $dob
        ]);

        $this->assertEquals($age, $cat->age_detail);

        Carbon::setTestNow();
    }

    /** @test */
    public function cat_has_age_string_attribute()
    {
        $today = '2018-02-02';
        Carbon::setTestNow($today);
        $cat = factory(Cat::class)->make(['dob' => '1997-01-01']);

        $ageString = '<div title="21 tahun, 1 bulan, 1 hari">21 tahun</div>';
        $this->assertEquals($ageString, $cat->age_string);

        Carbon::setTestNow();
    }

    /** @test */
    public function a_cat_has_birthday_attribute()
    {
        $dateOfBirth = '1990-01-01';

        $customer = factory(Cat::class)->create(['dob' => $dateOfBirth]);

        $birthdayDate = date('Y').substr($dateOfBirth, 4);
        $birthdayDateClass = Carbon::parse($birthdayDate);

        if (Carbon::parse(date('Y-m-d').' 00:00:00')->gt($birthdayDateClass)) {
            $currentYearBirthday = $birthdayDateClass->addYear();
        } else {
            $currentYearBirthday = $birthdayDateClass;
        }

        $this->assertEquals($currentYearBirthday, $customer->birthday);
    }

    /** @test */
    public function a_cat_has_birthday_remaining_attribute()
    {
        $dateOfBirth = '1990-01-01';

        $customer = factory(Cat::class)->create(['dob' => $dateOfBirth]);

        $birthdayDate = date('Y').substr($dateOfBirth, 4);
        $birthdayDateClass = Carbon::parse($birthdayDate);

        if (Carbon::now()->gt($birthdayDateClass)) {
            $currentYearBirthday = $birthdayDateClass->addYear()->format('Y-m-d');
        } else {
            $currentYearBirthday = $birthdayDateClass->format('Y-m-d');
        }

        $this->assertEquals(
            Carbon::now()->diffInDays($birthdayDateClass, false),
            $customer->birthday_remaining
        );
    }
}
