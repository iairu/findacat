@extends('layouts.app')

@section('ext_css')
<style>
body {
        background-image: url("images/cat-1045782-3.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
    }
.navbar-default  {
        background: white;
}
</style>
@endsection

@section('title',trans('backup.index_title'))

@section('content')
<h3 class="page-header">{{ trans('backup.index_title') }}</h3>
<div class="row">
    <div class="col-md-8">
            <h3>CSV Backup Import</h3>
            <p>Order and format of columns in CSV import has to be kept as in export.</p>
            <p>- As of 2024-03-19 column order has to be as follows: id, full_name, gender_id, sire_id, dam_id, dob, titles_before_name, titles_after_name, ems_color, breed, chip_number, genetic_tests, breeding_station, country_code, alternative_name, print_name_r1, print_name_r2, dod, original_reg_num, last_reg_num, reg_num_2, reg_num_3, notes, breeder, current_owner, country_of_origin, country, ownership_notes, personal_info, photo, vet_confirmation, doo
            <p>- The "id" column works as a UUID meaning that you can input any unique IDs you desire.</p>
            <p>- Existing UUIDs won't be replaced.</p>
            <p>As CSV integrity can't be guaranteed, here is the recommended usage:</p>
            <p>- Create a backup using GZ first guaranteeing valid integrity</p>
            <p>- The first backup can be on an empty database, this is recommended so you can easily restore the original state.</p>
            <p>- Use CSV import feature afterwards.</p>
            <p>- If integrity breaks restore given GZ backup.</p>
            <p>- Necessary: You must include id "1" with full_name set to "no origin" or similar for correct family trees and inbreeding calculation.</p>
            <p>- Dates of birth set to 1111-11-11 will have a note stating "Not set"</p>
</p>
    </div>
</div>
@endsection
