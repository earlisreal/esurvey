Login using username or email
Edit "vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers"
modify login function

    if (Auth::guard($this->getGuard())->attempt(['username' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }else if(Auth::guard($this->getGuard())->attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }