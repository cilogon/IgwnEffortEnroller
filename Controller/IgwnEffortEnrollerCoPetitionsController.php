<?

App::uses('CoPetitionsController', 'Controller');

class IgwnEffortEnrollerCoPetitionsController extends CoPetitionsController {
  // Class name, used by Cake
  public $name = "IgwnEffortEnrollerCoPetitions";
  public $uses = array("CoPetition");

  protected function execute_plugin_finalize($id, $onFinish) {
    // IGWN effort logic goes here.



    $this->log("IgwnEffort enroller finalize is called");





    // Redirect now that we are done.
    $this->redirect($onFinish);
  }

}
