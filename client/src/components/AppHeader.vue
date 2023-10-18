<template>
  <div id="header">
    <div class="container">
      <!-- Navbar ================================================== -->
      <div id="logoArea" class="navbar">
        <a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <div class="navbar-inner">
          <router-link to="/" class="brand"><img class="logo-img" src="../../public/themes/images/large_truecasual.png" alt="Bootsshop"/>
          </router-link>
          <form class="form-inline navbar-search" method="post" action="products.html">
            <input id="srchFld" class="srchTxt" type="text"/>
            <select class="srchTxt">
              <option>All</option>
              <option>CLOTHES</option>
              <option>FOOD AND BEVERAGES</option>
              <option>HEALTH & BEAUTY</option>
              <option>SPORTS & LEISURE</option>
              <option>BOOKS & ENTERTAINMENTS</option>
            </select>
            <button type="submit" id="submitButton" class="btn btn-primary">Знайти</button>
          </form>
          <ul id="topMenu" class="nav pull-right">
            <li class=""><a href="special_offer.html">Спеціальні пропозиції</a></li>
            <li class=""><a href="normal.html">Доставка</a></li>
            <li class=""><a href="contact.html">Про нас</a></li>
            <li class="">
              <a href="#login" role="button" data-toggle="modal" style="padding-right:0"><span
                  class="btn btn-large btn-success">Login</span></a>
              <div id="login" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login"
                   aria-hidden="false">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h3>Login Block</h3>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal loginFrm">
                    <div class="control-group">
                      <input type="text" id="inputEmail" placeholder="Email">
                    </div>
                    <div class="control-group">
                      <input type="password" id="inputPassword" placeholder="Password">
                    </div>
                    <div class="control-group">
                      <label class="checkbox">
                        <input type="checkbox"> Remember me
                      </label>
                    </div>
                  </form>
                  <button type="submit" class="btn btn-success">Sign in</button>
                  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AppHeader"
}
</script>

<style scoped>

.logo-img {
  height: 65px;
  margin-top: -8px ;

}

</style>