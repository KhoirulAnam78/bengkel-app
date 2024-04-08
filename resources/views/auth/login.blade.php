@extends('layouts.auth.app')

@section('title', 'Sign In')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Selamat Datang !</h5>
                        <p class="text-muted">Masukkan username dan password untuk mengakses aplikasi !</p>
                    </div>
                    <div class="p-2 mt-4">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="text" class="form-label">Username</label>
                                <input type="username" class="form-control" id="username" placeholder="Enter username"
                                    name="username" value="{{ old('username') }}" required placeholder="Username" autofocus>
                                <x-form.validation.error name="username" />
                            </div>

                            <div class="mb-3">
                                <div class="float-end">
                                    {{-- <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a> --}}
                                </div>
                                <label class="form-label" for="password-input">Password</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5" placeholder="Enter password"
                                        id="password-input" name="password" required placeholder="Password"
                                        autocomplete="current-password">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted"
                                        type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                    <x-form.validation.error name="password" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

        </div>
    </div>
@endsection
