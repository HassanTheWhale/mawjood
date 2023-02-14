@extends('layouts.master')

@section('content')
    <div class="top h-8 bg-prime2 text-white text-center overflow-hidden">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-2"></div>
            <div class="col-8">
                <h4 class="m-0">Create Events</h4>
            </div>
            <div class="col-2 pe-5"></div>
        </div>
    </div>
    <div class="content h-84 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <form action="">
                        <div class="form-group mb-3">
                            <label for="eventName" class="span ms-3 mb-1">
                                Event Name
                            </label>
                            <input type="text" name="eventName" id="eventName" placeholder="your event name"
                                class="form-control w-100 mb-1" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="eventDesc" class="span ms-3 mb-1">
                                Event Description
                            </label>
                            <textarea name="eventDesc" id="eventDesc" class="form-control" placeholder="Your Event Description"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="eventPic" class="span ms-3 mb-1">
                                Event Picture
                            </label>
                            <input type="file" name="eventPic" id="eventPic" placeholder="your event pic"
                                class="form-control w-100 mb-1" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="eventGrade" class="span ms-3 mb-1">
                                Min Grade
                            </label>
                            <input type="number" name="eventGrade" id="eventGrade"
                                placeholder="Min grade for sending certificates" class="form-control w-100 mb-1" />
                        </div>

                        <hr>

                        <div class="form-group mb-3">
                            <label for="eventSDate" class="span ms-3 mb-1"> Start Date </label>
                            <input type="date" name="eventSDate" id="eventSDate" placeholder=""
                                class="form-control w-100 mb-1" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="eventEDate" class="span ms-3 mb-1"> End Date </label>
                            <input type="date" name="eventEDate" id="eventEDate" placeholder=""
                                class="form-control w-100 mb-1" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="repeat" class="span ms-3 mb-1"> Repeat Every </label>
                            <br>
                            <input type="checkbox" value="Saturday" name="eventRepeatDay" id="Saturday" />
                            <label for="Saturday" class="span ms-3 mb-1 text-muted">
                                Saturday
                            </label>
                            <br>
                            <input type="checkbox" value="Sunday" name="eventRepeatDay" id="Sunday" />
                            <label for="Sunday" class="span ms-3 mb-1 text-muted">
                                Sunday
                            </label>
                            <br>
                            <input type="checkbox" value="Monday" name="eventRepeatDay" id="Monday" />
                            <label for="Monday" class="span ms-3 mb-1 text-muted">
                                Monday
                            </label>
                            <br>
                            <input type="checkbox" value="Tuesday" name="eventRepeatDay" id="Tuesday" />
                            <label for="Tuesday" class="span ms-3 mb-1 text-muted">
                                Tuesday
                            </label>
                            <br>
                            <input type="checkbox" value="Wendsday" name="eventRepeatDay" id="Wendsday" />
                            <label for="Wendsday" class="span ms-3 mb-1 text-muted">
                                Wendsday
                            </label>
                            <br>
                            <input type="checkbox" value="Thursday" name="eventRepeatDay" id="Thursday" />
                            <label for="Thursday" class="span ms-3 mb-1 text-muted">
                                Thursday
                            </label>
                            <br>
                            <input type="checkbox" value="Friday" name="eventRepeatDay" id="Friday" />
                            <label for="Friday" class="span ms-3 mb-1 text-muted">
                                Friday
                            </label>
                        </div>

                        <hr>

                        <div class="form-group mb-3">
                            <input type="checkbox" name="eventStrange" id="eventStrange" />
                            <label for="eventStrange" class="span ms-3 mb-1 text-muted">
                                Allow unregistered users to attend.
                            </label>
                        </div>

                        <button class="btn btn-primary text-white w-100">
                            Create the event
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom h-8 bg-prime2 overflow-hidden">
        <div class="row h-100">
            <div class="col-0 col-md-3"></div>
            <div class="col-12 col-md-6 h-100">
                <div class="row h-100 bg-prime">
                    <a href="./home" class="d-block col-3 h-100 p-0">
                        <div class="active w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/home.png" alt="Home" />
                        </div>
                    </a>

                    <a href="./search" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/search.png" alt="search for user" />
                        </div>
                    </a>

                    <a href="./certificates" class="d-block col-3 h-100 p-0">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/certificate.png" alt="My certificates" />
                        </div>
                    </a>

                    <a href="#" class="d-block col-3 h-100 p-0" id="profileButton">
                        <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <img src="./imgs/profile.png" alt="My Profile" />
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-0 col-md-3"></div>
        </div>
    </div>
@endsection
