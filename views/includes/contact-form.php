<?php HTML::renderMessageCodeFromUrl(); ?>
<div class="row">
    <form class="form-horizontal" method="post" action="controllers/controller-Contact.php?action=message">
      <fieldset>
        <div class="form-group">
          <!--<label for="inputName" class="col-lg-2 control-label">Nombre</label>-->
          <div class="col-lg-12">
            <input type="text" name="name" class="form-control" id="inputName" placeholder="Nombre">
          </div>
        </div>
        <div class="form-group">
          <!--<label for="inputEmail" class="col-lg-2 control-label">Email</label>-->
          <div class="col-lg-12">
            <input type="text" name="email" class="form-control" id="inputEmail" placeholder="Email">
          </div>
        </div>
        <div class="form-group">
          <!--<label for="inputPhone" class="col-lg-2 control-label">Tel&eacute;fono</label>-->
          <div class="col-lg-12">
            <input type="text" name="phone" class="form-control" id="inputPhone" placeholder="Tel&eacute;fono">
          </div>
        </div>
        <div class="form-group">
          <!--<label for="inputMessage" class="col-lg-2 control-label">Mensaje</label>-->
          <div class="col-lg-12">
              <textarea class="form-control" name="contactmessage" id="inputMessage" placeholder="Mensaje" rows="3"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-12">
            <button type="submit" class="btn btn-success">Enviar!</button>
          </div>
        </div>
      </fieldset>
    </form>
</div>