<div class="wrap">
  <h1>Ajánlatkérő színválasztó konfigurátor</h1>
</div>
<div ng-app="Szinvalaszto" ng-controller="Konfigurator" ng-init="init()">
  <div ng-show="!loaded">
    Adatok betöltése folyamatban...
  </div>
  <div ng-show="loaded">
    <div class="settings-group" ng-repeat="sg in settings_group">
      <div class="title">{{sg.title}}</div>
      <div class="settings-values">
        <div class="setting-value" ng-repeat="(i,sgv) in settings.groups[sg.key]">
          <div class="va-holder" style="background-color: {{sgv.value}};">
            <div class="va-wrapper">
              <div class="name">
                <input type="text" ng-model="sgv.name">
              </div>
              <div class="value">
                <input type="text" color-picker color-picker-model="sgv.value">
              </div>
            </div>
          </div>
          <div class="remover" ng-click="removeItem(sg.key, i)" title="Érték eltávolítása">
            <i class="fa fa-times"></i> törlés
          </div>
        </div>
      </div>
      <div ng-show="(settings.groups[sg.key].length == 0)">
        Nincs hozzáadva érték ehhez a paraméterhez.
      </div>
      <div class="add-value">
        <button type="button" ng-click="addItemValue(sg.key)">Érték hozzáadása <i class="fa fa-plus-circle"></i> </button>
      </div>
    </div>
    <div class="savers">
      <button type="button" ng-click="saveSettigns()">Változások mentése</button>
    </div>
  </div>
</div>
<style media="screen">
  .settings-group .title{
    font-size: 22px;
    text-transform: uppercase;
    font-weight: bold;
    color: #dbb17d;
    margin: 20px 0 10px 0;
  }
  .settings-values {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
  }
  .settings-values .setting-value{
    padding: 10px;
  }
  .settings-values .setting-value .va-holder{
    border: 2px solid #e7e7e7;
    padding: 20px;
    background-color: white;
    border-radius: 0 10px 0 10px;
  }
  .settings-values .setting-value .remover{
    text-align: center;
    color: red;
    font-size: 10px;
    cursor: pointer;
    margin: 5px 0 0 0;
    border-radius: 5px;
  }
  .settings-values .setting-value .remover:hover{
    background: #eaeaea;
  }
  .add-value{
    margin: 10px 0 0 0;
  }
  .add-value button {
    background: #959595;
    border: 1px solid #807e7e;
    padding: 2px 5px;
    color: white;
    font-size: 10px;
    cursor: pointer;
  }

  .savers {
    margin: 25px 0 0 0;
  }
  .savers button {
    background: #64ca89;
    border-radius: 4px;
    border: 2px solid #4ab671;
    padding: 5px 10px;
    color: white;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
  }
  .va-wrapper{
    position: relative;
  }
  .va-wrapper input[type=text]{
    background: rgba(255, 255, 255, 0.5);
    text-align: center;
    font-size: 10px;
    color: black;
    font-weight: bold;
    border: none;
  }
  .va-wrapper .value input[type=text]{
    cursor: pointer;
  }
</style>
