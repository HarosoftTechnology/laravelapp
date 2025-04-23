@extends('frontend.layouts.app')
@section('title', 'Login')

@section('content')
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
      <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="h-32 md:h-auto md:w-1/2">
            <img src="{{ asset('images/login.jpeg') }}" aria-hidden="true" class="object-cover w-full h-full dark:hidden" alt="Office"/>
          </div>
          
          <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
              <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">Login</h1>
              <form id="LoginForm" method="POST" action="">
                @csrf
                  <label class="block text-sm">
                    <span class="">Email</span>
                    <input type="text" name="email" class="form-input" placeholder="dele@testing.com" />
                  </label>
                  <label class="block text-sm">
                    <span>Password</span>
                    <div class="input-group">
                      <input type="password" name="password" class="form-input" placeholder="***************" />
                      <span class="input-group-text password-visibility cursor-pointer"><i class="fa fa-eye"></i></span>
                    </div>
                  </label>
                  
                  <button class="mt-6 w-full py-2 hover:bg-indigo-700 flex items-center justify-center hover:bg-purple-700 focus:shadow-outline focus:outline-none spin" data-send="false">
                    <i class="fa fa-spinner fa-spin"></i> <span class="ml-3">Login</span>
                  </button>
              </form>
            <div class="text-center mt-4 text-sm font-medium text-purple-600">
                <span> New on our platform? </span>
                <a href="{{ url('signup') }}">
                    <span>Create An Account</span>
                </a>
            </div>

            <div class="mt-4"><b>Email:</b> dele@testing.com</div>
            <div><b>Password:</b> 123456</div>

            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
