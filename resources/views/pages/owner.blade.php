@include('partials.head')
    <body>
       @include('partials.navbar')
        <div class="container-fluid mt-4">
          <h4 class="text-center text-uppercase pt-5">Manage Services</h4>
          <div class="row col-md-10 offset-md-1 mt-5">
            <div class="col-3 col-md-3">
              <button class="col-md-12 btn btn-secondary" id="manageServiceBtn" onclick="allServices()">All Services</button>
            </div>
            <div class="col-3 col-md-3">
              <button class="col-md-12 btn btn-secondary" onclick="pendingBooking()">Pending Services</button>
            </div>
            <div class="col-3 col-md-3">
              <button class="col-md-12 btn btn-secondary" onclick="readyForDeliveryBooking()">Ready for Delivery Services</button>
            </div>
            <div class="col-3 col-md-3">
              <button class="col-md-12 btn btn-secondary" onclick="previousBooking()">Completed Services</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10 offset-md-1 row shadow p-3 mb-5 rounded mt-5">
              <div class="col-md-4">
               <button type="button" id="addServiceBtn" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addServiceModal">Add Service</button>
              </div>
              <div class="table-responsive mt-3" id="allServiceDiv">
                <table class="table table-bordered table-striped table-hover dataTable" id="manageServiceTable" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Service Code</th>
                            <th>Service Name</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
              </div>

              <div class="table-responsive mt-3" id="allPendingBookingDiv">
                <table class="table table-bordered table-striped table-hover dataTable" id="managePendingBookingTable" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Booked User</th>
                            <th>Booking Name</th>
                            <th>Booking Date</th>
                            <th>Booking Status</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
              </div>

              <div class="table-responsive mt-3" id="allReadyForDeliveryBookingDiv">
                <table class="table table-bordered table-striped table-hover dataTable" id="manageReadyForDeliveryBookingTable" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Booked User</th>
                            <th>Booking Name</th>
                            <th>Booking Date</th>
                            <th>Booking Status</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
              </div>

              <div class="table-responsive mt-3" id="allPreviousBookingDiv">
                <table class="table table-bordered table-striped table-hover dataTable" id="manageCompletedBookingTable" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Booked User</th>
                            <th>Booking Name</th>
                            <th>Booking Date</th>
                            <th>Booking Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
              </div>

            </div>
          </div>
        </div>

          <!-- Modal -->
        <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <form id="serviceAddForm">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body">
                    <div class="mb-3 mt-3" required>
                      <label for="service_code" class="form-label">Service Code&nbsp;<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="serviceCode" name="service_code" required="">
                    </div>
                    <div class="mb-3 mt-3" required>
                      <label for="service_name" class="form-label">Service Name&nbsp;<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="serviceName" name="service_name" required="">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success">Create</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <form id="serviceEditForm">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body">
                  <input type="hidden" id="editServiceId" name="id">
                    <div class="mb-3 mt-3">
                      <label for="service_code" class="form-label">Service Code</label>
                      <input type="text" class="form-control" id="editServiceCode" name="service_code" placeholder="ww-102">
                    </div>
                    <div class="mb-3 mt-3">
                      <label for="service_name" class="form-label">Service Name</label>
                      <input type="text" class="form-control" id="editServiceName" name="service_name" placeholder="water wash">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="deleteServiceConfirmModal" tabindex="-1"aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <form id="serviceDeleteForm">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmtaion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body">
                  <input type="hidden" id="deleteServiceId" name="id">
                  <h5>Do you want to delete this service?</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
                </div>
              </form>
            </div>
          </div>
        </div>
       
        <script src="/js/bootstrap.bundle.min.js"></script>
        <script src="/js/jquery.min.js"></script>
        <script src="/js/jquery.dataTables.min.js"></script>
        <script src="/js/dataTables.bootstrap5.min.js"></script>
        <script src="/js/pnotify.min.js"></script>
        <script src="/js/pages/service.js"></script>
    </body>
</html>
