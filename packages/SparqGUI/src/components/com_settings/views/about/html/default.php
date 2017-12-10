<? defined('KOOWA') or die; ?>

<div class="row">
  <div class="span2">
      <?= @helper('ui.navigation', array('selected' => 'about')) ?>
  </div>
  <div class="span10">
      <?= @helper('ui.header') ?>

      <div class="an-entity">
          <div class="entity-description">
          <p><img src="https://s3-us-west-2.amazonaws.com/sparqedu.com/sparq_logo.png " alt="Sparq Network - for students, by students" /></p>
          <h2>Sparq &amp; Phase 4</h2> 
          </div>
          <dl class="entity-meta">
              <dt>Version</dt>
              <dd><?= 4.0.0 ?></dd>
              <dt>License</dt>
              <dd><a href="https://www.gnu.org/licenses/gpl-3.0.en.html" target="_blank">GPLv3</a></dd>
              <dt>Website</dt>
              <dd><a href="https://www.sparqedu.com" target="_blank">SparqEdu.com</a></dd>
          </dl>
      </div>
  </div>
</div>
