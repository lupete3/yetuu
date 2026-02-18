
@extends('layouts.pdf')

@section('content')
<style>
  td,th{
    font-size:1em;

  }
</style>


    <!-- Main Content -->
    <div class="main-content">

        <section class="section">
            <div class="section-header valider">

            </div>

            <div class="section-body ">

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 align-center">

                      <div class="row" style="margin-bottom:10px;  " >
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <center>
                                <p style="font-weight:bold; font-family:Century Gothic; font-size:1em;" >
                                    {{ $viewData['title'] }}
                                </p>
                            </center>
                        </div>

                      </div>

                      <div class="container">
                        <div class="row" style="margin-bottom:10px;  " >
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="container">
                                    <div class="row spacer" style="margin-bottom:20px; " >

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-bordered table-striped table-sm" style="font-size: 1em">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Farmer ID</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Date of Birth</th>
                                                        <th>Gender</th>
                                                        <th>Country</th>
                                                        <th>State/Province</th>
                                                        <th>Territory</th>
                                                        <th>Village</th>
                                                        <th>Operational Site</th>
                                                        <th>Number of Family Members</th>
                                                        <th>Main Occupation</th>
                                                        <th>Level of Education</th>
                                                        <th>Civil Status</th>
                                                        <th>Association Member</th>
                                                        <th>Association Name</th>
                                                        <th>Contact Number</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($viewData['farmers'] as $index => $farmer)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $farmer->farmer_id }}</td>
                                                            <td>{{ $farmer->first_name }}</td>
                                                            <td>{{ $farmer->last_name }}</td>
                                                            <td>{{ $farmer->date_of_birth ?? 'N/A' }}</td>
                                                            <td>{{ $farmer->gender ?? 'N/A' }}</td>
                                                            <td>{{ $farmer->country->name ?? 'N/A' }}</td>
                                                            <td>{{ $farmer->state_province->name ?? 'N/A' }}</td>
                                                            <td>{{ $farmer->territory->name ?? 'N/A' }}</td>
                                                            <td>{{ $farmer->village ?? 'N/A' }}</td>
                                                            <td>{{ $farmer->operational_site ?? 'N/A' }}</td>
                                                            <td>{{ $farmer->number_of_family_members ?? 'N/A' }}</td>
                                                            <td>{{ $farmer->main_occupation ?? 'N/A' }}</td>
                                                            <td>{{ $farmer->level_of_education ?? 'N/A' }}</td>
                                                            <td>{{ $farmer->civil_status ?? 'N/A' }}</td>
                                                            <td>{{ $farmer->is_member_of_association ? 'Yes' : 'No' }}</td>
                                                            <td>{{ $farmer->association_name ?? 'N/A' }}</td>
                                                            <td>{{ $farmer->contact_number }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>

                                <div class="row">


                                  <div class="col-md-3 offset-3">
                                    <button type="button" class="btn btn-primary print pull-right valider"><span class="fa fa-print"></span> Imprimer</button>
                                  </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

<style>
  th,td{font-size: 2em;}
</style>




