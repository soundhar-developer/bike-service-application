@include('partials.head')
<body class="bg-body">
   @include('partials.navbar')
    <div class="container mt-5 p-5">
      <div class="col-md-6 offset-md-3 row mt-5">
        <div class="col-md-11 shadow p-3 mb-5 bg-body rounded bg-card">
          <h4 class="text-center mb-3">Sign In</h4>
          <form id="loginForm">
            @csrf
            <div class="mb-3 mt-3 required">
              <label for="email" class="form-label">Email&nbsp;<span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="email" name="email" required>
              
            </div>
            <div class="mb-3 mt-3 required">
              <label for="password" class="form-label">Password&nbsp;<span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary text-center">Sign In</button>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <span>Don't have an account ?</span>&nbsp;<a href="/register">Sign Up</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    @include('partials.script')
</body>
</html>
