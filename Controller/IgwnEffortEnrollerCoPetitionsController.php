<?

App::uses('CoPetitionsController', 'Controller');

class IgwnEffortEnrollerCoPetitionsController extends CoPetitionsController {
  // Class name, used by Cake
  public $name = "IgwnEffortEnrollerCoPetitions";
  public $uses = array("CoPetition");

  protected function execute_plugin_finalize($id, $onFinish) {
    // IGWN effort logic goes here.

    $this->log("IgwnEffort enroller finalize is called with petition $id and " . print_r($onFinish, true));

    $args = array();
    $args['conditions']['CoPetition.id'] = $id;
    $args['contain'] = false;

    $coPetition = $this->CoPetition->find('first', $args);

    $this->log("Found petition " . print_r($coPetition, true));


    $this->Session->write('Igwn.plugin.effort.enroller.onFinish', $onFinish);

    $foo = $this->Session->read('Igwn.plugin.effort.enroller.onFinish');

    $this->log("Foo is " . print_r($foo, true));


    // Redirect now that we are done.
    $this->redirect($onFinish);
  }

}
