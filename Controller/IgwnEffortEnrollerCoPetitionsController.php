<?php

App::uses('CoPetitionsController', 'Controller');

class IgwnEffortEnrollerCoPetitionsController extends CoPetitionsController {
  // Class name, used by Cake
  public $name = "IgwnEffortEnrollerCoPetitions";
  public $uses = array("CoPetition");

  protected function execute_plugin_finalize($id, $onFinish) {
    // Use the petitition ID to find the petition and include
    // the COU and CO Person Role objects.
    $args = array();
    $args['conditions']['CoPetition.id'] = $id;
    $args['contain'] = array('Cou', 'EnrolleeCoPersonRole');

    $coPetition = $this->CoPetition->find('first', $args);

    $curStatus = $coPetition['CoPetition']['status'];

    // First check to see if the petition was denied (or declined). If so, then do not prompt to enter effort hours!
    if($curStatus == PetitionStatusEnum::Declined || $curStatus == PetitionStatusEnum::Denied)
    {
      $this->redirect($onFinish);
    }

    // Use the details from the petition, COU, and CO Person Role
    // to construct the URL into the IGWN Effort Manager view.
    $pluginRedirect = array();
    $pluginRedirect['plugin'] = 'igwn_effort_manager';
    $pluginRedirect['controller'] = 'co_igwn_role_effort';
    $pluginRedirect['action'] = 'add';
    $pluginRedirect['co'] = $coPetition['CoPetition']['co_id'];
    $pluginRedirect['role_id'] = $coPetition['CoPetition']['enrollee_co_person_role_id'];
    $pluginRedirect['cou_name'] = $coPetition['Cou']['name'];
    $pluginRedirect['cou_id'] = $coPetition['Cou']['id'];
    $pluginRedirect['co_person_id'] = $coPetition['CoPetition']['enrollee_co_person_id'];
    $pluginRedirect['affiliation'] = $coPetition['EnrolleeCoPersonRole']['affiliation'];

    // Record the enrollment flow URL re-entry point in a session variable
    // so that the IGWN Effort Manager plugin can redirect back into
    // the enrollment flow at the correct point.
    $this->Session->write('Igwn.plugin.effort.enroller.onFinish', $onFinish);

    // Redirect into the IGWN Effort Manager plugin.
    $this->redirect($pluginRedirect);
  }
}
