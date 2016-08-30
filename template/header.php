<?php //echo '<pre style="text-align: left">' . print_r($this->userInfo['app_metadata'], 1) . '</pre>'; ?>

<div class="top">
    
<div class="user">
<img src="<?= $this->userInfo['picture'] ?>" id="avatar" alt="<?= $this->userInfo['name'] ?>" title="<?= $this->userInfo['name'] ?>"><?= $this->userInfo['name'] ?>
  <?php if (is_array($_SESSION['auth0__user']['app_metadata']['client'])) { ?> for
    <select name="account" class="form-control selectpicker" onchange="window.location='?action=switch&advertiser=' + this.options[this.selectedIndex].value" style="display: inline-block; width: auto">
      <?php
      $old_accounts = array('expert', 'firecracker', 'power', 'rio', 'sticky-fingers', 'xxl');
      foreach($_SESSION['auth0__user']['app_metadata']['client'] as &$val) {
        echo '<option value="' . $val . '"' . ($val == $_SESSION['auth0__user']['app_metadata']['current_client'] || $val == (is_array($_SESSION['auth0__user']['app_metadata']['client']) ? $_SESSION['auth0__user']['app_metadata']['client'][0] : $user['app_metadata']['client']) ? ' selected' : '') . '>' . str_replace('-', ' ', ($val == 'xxl' ? strtoupper($val) : ucfirst($val))) . '</option>';
      }
      ?>
    </select>
  <?php } ?>
</div>
    
<div class="logo"><a href="http://firelabs.no/"><img id="logo" src="img/logo.svg" alt="Firelabs logotyp" title="Firelabs logotyp"></a></div>
    
</div>