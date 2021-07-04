<nav class="navbar navbar-light bg-light fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand text-uppercase">Bike Service Station</a>
    <form class="d-flex">
      <a href="/logout" id="logoutBtn" onclick="logout()" class="btn btn-secondary me-2 logout-btn-none" type="button">Logout</a>
    </form>
  </div>
</nav>
<script src="/js/jquery.min.js"></script>
<script>
	function logout() {
	    window.localStorage.clear();
	}

	$(document).ready(function() {
	    var path = window.location.href.split(/[\s/]+/);
	    var param = path[path.length - 1];
	    if(param != "login" || param != "register") {
	        $('#logoutBtn').removeClass('logout-btn-none');
	        $('#logoutBtn').addClass('logout-btn-show');
	    }
	})
</script>