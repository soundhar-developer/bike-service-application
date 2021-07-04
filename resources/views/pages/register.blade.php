@include('partials.head')
<body class="bg-body">
   @include('partials.navbar')
    <div class="container mt-5">
      <div class="col-md-6 offset-md-3 row mt-5">
        <div class="col-md-11 shadow p-3 mt-5 mb-5 bg-body rounded bg-card">
          <h4 class="text-center">Customer Registration</h4>
          <form id="registerForm">
            @csrf
            <div class="mb-3 mt-3 required">
              <label for="name" class="form-label">Name&nbsp;<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="name" name="name" autocomplete="false" placeholder="User Name"  required>
            </div>
            <div class="mb-3 mt-3 required">
              <label for="email" class="form-label">Email&nbsp;<span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="email" name="email" autocomplete="false" placeholder="Email"  required>
            </div>
            <div class="mb-3 mt-3 required">
              <label for="mobile" class="form-label">Mobile&nbsp;<span class="text-danger">*</span></label>
              <input type="tel" class="form-control" id="mobile" name="mobile" autocomplete="false" pattern="[0-9]{10}" required placeholder="l0 digit mobile number">
            </div>
            <div class="mb-3 mt-3 required">
              <label for="password" class="form-label">Password&nbsp;<span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
            </div>
            <div class="d-flex justify-content-center mt-2">
                <button type="submit" id="registerCustomer" class="btn btn-primary text-center">Register</button>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <span>Do you have an account ?</span>&nbsp;<a href="/login">Sign In</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    @include('partials.script')
</body>
</html>
