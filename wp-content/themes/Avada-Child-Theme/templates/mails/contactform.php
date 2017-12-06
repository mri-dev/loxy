<h1>Új <?php echo $contact_type; ?> érkezett!</h1>
<?php if (isset($name) && !empty($name)): ?>
<div>Név: <strong><?php echo $name; ?></strong></div>
<?php endif; ?>
<?php if (isset($email) && !empty($email)): ?>
<div>E-mail: <strong><?php echo $email; ?></strong></div>
<?php endif; ?>
<?php if (isset($phone) && !empty($phone)): ?>
<div>Telefon: <strong><?php echo $phone; ?></strong></div>
<?php endif; ?>
<?php if (isset($irsz) && !empty($irsz)): ?>
<div>Irányítószám: <strong><?php echo $irsz; ?></strong></div>
<?php endif; ?>
<?php if (isset($helyseg) && !empty($helyseg)): ?>
<div>Helységnév: <strong><?php echo $helyseg; ?></strong></div>
<?php endif; ?>
<?php if ($szinvalaszto): ?>
  <h3 style="margin: 10px 0 5px 0;">Színválasztó - Kiválasztott konfiguráció:</h3>
  <div>Ház alap: <strong><?php echo $colorconfig['haz_alap']; ?></strong></div>
  <div>Ház teteje: <strong><?php echo $colorconfig['haz_teteje']; ?></strong></div>
  <div>Ház hátfala: <strong><?php echo $colorconfig['haz_hatfal']; ?></strong></div>
<?php endif; ?>
<br>
<div>Üzenet: <br>
<strong><?php echo $uzenet; ?></strong></div>
<br><br>
-------- <br>
Küldve a(z) <strong><?php echo get_option('blogname'); ?></strong> weboldal kapcsolatfelvételi és ajánlatkérő rendszerével.
