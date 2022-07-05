@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            Hello, {{Auth()->user()->name}}
            <br>
            <form action="{{ route('add.meeting') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" class="form-control" name="event_name" placeholder="Event" required>
                    </div>
                    <div class="col">
                        <select name="country" class="form-control selectpicker" data-live-search="true" id="country" required>
                            <option value="">Select country</option>
                            @foreach ($countries as $item)
                            <option value="{{$item['name']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <select name="state" class="form-control selectpicker" data-live-search="true" id="state" required>
                            <option value="">Select state</option>
                        </select>
                    </div>
                    <div class="col">
                        <select name="city" class="form-control selectpicker" data-live-search="true" id="city" required>
                            <option value="">Select city</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" placeholder="Current temperature" name="temperature" class="form-control"
                            id="#temperature" value="" readonly>
                    </div>
                    <div class="col">
                        <input type="text" placeholder="Current weather" name="weatherDes"
                            class="form-control text-capitalize" id="#weatherDes" value="" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" class="form-control" name="name" placeholder="Contact person name">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="mobile_number" placeholder="Mobile number">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" class="form-control" name="key_note" placeholder="Example keep warm clothes">
                    </div>
                    <div class="col">
                        <input type="datetime-local" class="form-control" name="meeting_slot" placeholder="Time">
                    </div>
                </div>
                <button class="btn btn-primary mt-2" type="submit">Add meeting</button>
            </form>
            <br>
            <button type="button" style="display: none;" class="btn btn-primary" data-toggle="modal"
                data-target="#editModal" id="editBtn">
                Launch demo modal
            </button>
            <button type="button" style="display: none;" class="btn btn-primary" data-toggle="modal"
                data-target="#deleteModal" id="deleteBtn">
                Launch demo modal
            </button>

            <!-- Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Update meeting</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('edit.meeting') }}" method="POST">
                                @csrf
                                <input type="text" class="form-control" id="event_name" name="event_name"
                                    placeholder="Event">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Contact person name">
                                <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                                    placeholder="Mobile number">
                                <input type="text" class="form-control" id="key_note" name="key_note"
                                    placeholder="Pack luggage as per weather">
                                <input type="hidden" name="eventId" id="eventId">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Delete meeting</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <form action="{{ route('delete.meeting') }}" method="POST">
                                @csrf
                                <input type="hidden" class="form-control" id="eventIdDel" name="eventIdDel"
                                    placeholder="Event">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <table id="table_id" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Event</th>
                <th>Name</th>
                <th>Contact number</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Temperature &#x2103;</th>
                <th>Weather Description</th>
                <th>Notes</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->event_name}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->mobile_number}}</td>
                <td>{{$item->country}}</td>
                <td>{{$item->state}}</td>
                <td>{{$item->city}}</td>
                <td>{{$item->temperature}}</td>
                <td class="text-capitalize">{{$item->weatherDes}}</td>
                <td>{{$item->key_note}}</td>
                <td>{{date('d/m/Y h:m a', strtotime($item->meeting_slot))}}</td>
                <td> <button class="btn btn-primary btn-sm" type="button" class="btn btn-primary"
                        data-event_id="{{$item->id}}" onclick="updateEvent({{$item->id}})">Edit</button>
                    <button class="btn btn-danger btn-sm mt-2" data-event_id="{{$item->id}}"
                        onclick="deleteEvent({{$item->id}})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    function updateEvent(id){
       $.ajax({
        url: " {{ route('get.meeting') }} ",
        type:"POST",
        data: {
            'id': id,
            '_token': " {{ csrf_token() }} "
        },
        success: function(data){
            $('#eventId').val(data.id);
            $('#event_name').val(data.event_name);
            $('#name').val(data.name);
            $('#mobile_number').val(data.mobile_number);
            $('#key_note').val(data.key_note);
            $('#meeting_slot').val(data.meeting_slot);
            $('#editBtn').trigger('click');
        }
       });
    }
    function deleteEvent(id){
        $('#eventIdDel').val(id);
        $('#deleteBtn').trigger('click');
    }

    $(document).ready(function(){
    $('#country').change(function(){
       let country = $(this).val();

       if(country != '' || country != null){
            $.ajax({
                url: "https://countriesnow.space/api/v0.1/countries/states",
                type:"POST",
                data: {
                    "country": country
                },success: function(response){

                    let statesData = response.data.states;
                    // console.log(states);
                    let states = "";
                    $.each(statesData, function(key, value) {
                        states += "<option value='"+value.name+"'>"+value.name+"</option>";
                    });
                    $('#state').html(states);
                    $('.selectpicker').selectpicker('refresh');
                }
            });
        }
    });

    $('#state').change(function(){
        let country = $('#country').val();
        let state = $(this).val();

       if(country != null || country != '' || state != '' || state != null){
            $.ajax({
                url: "https://countriesnow.space/api/v0.1/countries/state/cities",
                type:"POST",
                data: {
                    "country": country,
                    "state": state
                },success: function(response){

                    let citiesData = response.data;
                    let cities = "";
                    $.each(citiesData, function(key, value) {
                        cities += "<option value='"+value+"'>"+value+"</option>";
                    });
                    $('#city').html(cities);
                    $('.selectpicker').selectpicker('refresh');
                }
            });
        }
    });

    $('#city').change(function(){
        let city = $(this).val();

       if(city != null || city != ''){
            $.ajax({
                url: "http://api.openweathermap.org/data/2.5/weather?q="+city+"&appid=1f3c5ae0f38df8fd7bc09ad6874a4039",
                type:"POST",
                success: function(response){
                    let temperature = response.main.temp;
                    document.getElementById("#temperature").value = (parseInt(temperature) - 273.15).toFixed(0); 
                    let temperatureDes = response.weather[0].description;
                    document.getElementById("#weatherDes").value = temperatureDes;
                }
            });
        }
    });
     });
</script>
@endsection