<a name="_form"></a>
<form id="mailsend" action="" method="post">
  <input type="hidden" name="formtype" value="<?=$tipus?>">
  <input type="hidden" name="szinvalaszto" value="<?=($szinvalaszto)?1:0?>">
  <?php if ($szinvalaszto): ?>
  <div class="color-selection" ng-app="Szinvalaszto" ng-controller="FormSelector" ng-init="init()">
    <div ng-show="!loaded" class="loading-text">
      Színválasztó betöltése folyamatban... <i class="fa fa-spin fa-spinner"></i>
    </div>
    <div ng-show="loaded">
      <div class="set-group" ng-repeat="group in settings_group" ng-show="(settings.groups[group.key].length!=0)">
        <h2>{{group.title}}</h2>
        <div class="req-select-msg" id="selreq-colorconfig-{{group.key}}" style="display:none;">
          Kérjük, hogy válasszon egy színvariációt a listából:
        </div>
        <div class="group_selection">
          <div ng-repeat="color in settings.groups[group.key]">
            <div class="cwrapper" style="background-color:{{color.value}};">
              <label for="{{group.key}}_{{color.name}}"><div class="name">{{color.name}}</div></label>
            </div>
            <div class="mod">
              <input type="radio" name="colorconfig[{{group.key}}]" id="{{group.key}}_{{color.name}}" value="{{color.name}}"><label for="{{group.key}}_{{color.name}}"></label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
  <div class="group-holder requester-holder" style="width: <?=$width?>%;">
      <div class="flxtbl">
        <div class="name">
          <div class="form-input-holder">
            <input type="text" id="name" name="name" class="form-control" placeholder="Név *" value="">
          </div>
        </div>
        <div class="email">
          <div class="form-input-holder">
            <input type="text" id="email" name="email" class="form-control" placeholder="E-mail *" value="">
          </div>
        </div>
        <div class="phone">
          <div class="form-input-holder">
            <input type="text" id="phone" name="phone" class="form-control" placeholder="Telefon *" value="">
          </div>
        </div>
        <?php if ($tipus == 'szallitas'): ?>
        <div class="irsz">
          <div class="form-input-holder">
            <input type="number" id="irsz" maxlength="4" name="irsz" class="form-control" placeholder="Irányítószám *" value="">
          </div>
        </div>
        <div class="helyseg">
          <div class="form-input-holder">
            <input type="text" id="helyseg" name="helyseg" class="form-control" placeholder="Helységnév *" value="">
          </div>
        </div>
        <?php endif; ?>
        <div class="uzenet">
          <div class="form-input-holder">
            <textarea name="uzenet" id="uzenet" class="form-control" placeholder="Üzenet"></textarea>
          </div>
        </div>
        <div class="recaptcha">
          <div class="g-recaptcha" data-sitekey="<?=CAPTCHA_SITE_KEY?>"></div>
        </div>
      </div>
  </div>

  <div class="btns">
    <div id="mail-msg" style="display: none; width: <?=$width?>%;">
      <div class="alert"></div>
    </div>
    <button type="button" id="mail-sending-btn" onclick="ajanlatkeresKuldes();"><?php echo $button_text; ?></button>
  </div>

</form>


<script type="text/javascript">
var mail_sending_progress = 0;
var mail_sended = 0;
function ajanlatkeresKuldes()
{
  if(mail_sending_progress == 0 && mail_sended == 0){
    jQuery('#mail-sending-btn').html('<?php echo __('<?php echo $whatisit; ?> küldése folyamatban', 'Avada'); ?> <i class="fa fa-spinner fa-spin"></i>').addClass('in-progress');
    jQuery('#mailsend .missing').removeClass('missing');

    mail_sending_progress = 1;
    var mailparam  = jQuery('#mailsend').serializeArray();
    jQuery.post(
      '<?php echo admin_url('admin-ajax.php'); ?>?action=contact_form',
      mailparam,
      function(data){
        var resp = jQuery.parseJSON(data);
        console.log(resp);
        if(resp.error == 0) {
          mail_sended = 1;
          jQuery('#mail-sending-btn').html('<?php echo __( $whatisit.' elküldve', 'Avada'); ?> <i class="fa fa-check-circle"></i>').removeClass('in-progress').addClass('sended');
        } else {
          jQuery('#mail-sending-btn').html('<?php echo $button_text; ?>').removeClass('in-progress');
          jQuery('#mail-msg').show();
          jQuery('#mail-msg .alert').html(resp.msg).addClass('alert-danger');
          mail_sending_progress = 0;
          if(resp.missing != 0) {
            jQuery.each(resp.missing_elements, function(i,e){
              jQuery('#mailsend #'+e).addClass('missing');
            });

            if (resp.missing_elements.indexOf('colorconfig_haz_alap') !== false) {
              jQuery('#selreq-colorconfig-haz_alap').show();
            } else {
              jQuery('#selreq-colorconfig-haz_alap').hide();
            }
            if (resp.missing_elements.indexOf('colorconfig_haz_teteje') !== false) {
              jQuery('#selreq-colorconfig-haz_teteje').show();
            } else{
              jQuery('#selreq-colorconfig-haz_teteje').hide();
            }
            if (resp.missing_elements.indexOf('colorconfig_haz_hatfal') !== false) {
              jQuery('#selreq-colorconfig-haz_hatfal').show();
            } else {
              jQuery('#selreq-colorconfig-haz_hatfal').hide();
            }
          }
        }
      }
    );
  }
}
</script>
