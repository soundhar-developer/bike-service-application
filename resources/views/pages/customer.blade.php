@include('partials.head')
    <body>
        @include('partials.navbar')
        <div class="container-fluid mt-5">
          <h4 class="pt-5 text-center text-uppercase">Book Services</h4>
          <div class="row col-md-10 offset-md-1 mt-5">
            <div class="col-6 col-md-6">
              <button class="col-md-12 btn btn-secondary" id="manageBookingServiceBtn" onclick="currentBooking()">Current Booking</button>
            </div>
            <div class="col-6 col-md-6">
              <button class="col-md-12 btn btn-secondary" onclick="previousBooking()">Previous Bookings</button>
            </div>
          </div>
          <div class="row col-md-10 offset-md-1 shadow p-3 mb-5 rounded mt-5">
            <div class="col-md-4">
             <button type="button" id="bookServiceBtn" class="btn btn-secondary" data-bs-toggle="modal" onclick="loadAllServices()" data-bs-target="#addBookingModal">Book Service</button>
            </div>
            <div class="table-responsive mt-3" id="allCurrentBoookingDiv">
              <table class="table table-bordered table-striped table-hover table-responsive dataTable" id="manageCurrentBookingTable" style="width: 100%">
                  <thead>
                      <tr>
                          <th>Booking Name</th>
                          <th>Service Name</th>
                          <th>Booking Date</th>
                          <th>Booking Status</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
              </table>
            </div>
            <div class="table-responsive mt-3" id="allPreviousBookingDiv">
              <table class="table table-bordered table-striped table-hover table-responsive dataTable" id="managePreviousBookingTable" style="width: 100%">
                  <thead>
                      <tr>
                          <th>Booking Name</th>
                          <th>Service Name</th>
                          <th>Booking Date</th>
                          <th>Booking Status</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
              </table>
            </div>

          </div>
        </div>

          <!-- Modal -->
        <div class="modal fade" id="addBookingModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <form id="bookingAddForm">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Book Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body">
                  <input type="hidden" name="status" value="pending">
                  <input type="hidden" name="user_id" id="userId">
                  <div class="mb-3 mt-3" required>
                      <label for="service_code" class="form-label">Choose Service&nbsp;<span class="text-danger">*</span></label>
                      <select class="form-control selectpicker" id="serviceId" name="service_name[]" multiple="multiple" required>
                      </select>
                  </div>
                  <div class="mb-3 mt-3" required>
                      <label for="service_code" class="form-label">Booking Name&nbsp;<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="bookingName" name="booking_name" required>
                  </div>
                    
                    <div class="mb-3 mt-3" required>
                      <label for="service_name" class="form-label">Booking Date&nbsp;<span class="text-danger">*</span></label>
                      <input type="date" class="form-control" id="serviceDate" name="booking_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success">Create</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        @include('partials.script')
    </body>
</html>
