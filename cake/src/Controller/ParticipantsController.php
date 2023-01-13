<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Participants Controller
 *
 * @property \App\Model\Table\ParticipantsTable $Participants
 *
 * @method \App\Model\Entity\Participant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ParticipantsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Timings'],
        ];
        $participants = $this->paginate($this->Participants);

        $this->set(compact('participants'));
    }

    /**
     * View method
     *
     * @param string|null $id Participant id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $participant = $this->Participants->get($id, [
            'contain' => ['Timings', 'Codes'],
        ]);

        $this->set('participant', $participant);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $participant = $this->Participants->newEntity();
        if ($this->request->is('post')) {
            $participant = $this->Participants->patchEntity($participant, $this->request->getData());
            if ($this->Participants->save($participant)) {
                $this->Flash->success(__('The participant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The participant could not be saved. Please, try again.'));
        }
        $timings = $this->Participants->Timings->find('list', ['limit' => 200]);
        $codes = $this->Participants->Codes->find('list', ['limit' => 200]);
        $this->set(compact('participant', 'timings', 'codes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Participant id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $participant = $this->Participants->get($id, [
            'contain' => ['Codes'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $participant = $this->Participants->patchEntity($participant, $this->request->getData());
            if ($this->Participants->save($participant)) {
                $this->Flash->success(__('The participant has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The participant could not be saved. Please, try again.'));
        }
        $timings = $this->Participants->Timings->find('list', ['limit' => 200]);
        $codes = $this->Participants->Codes->find('list', ['limit' => 200]);
        $this->set(compact('participant', 'timings', 'codes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Participant id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function codeAnswers($id = null)
    {
        // Get all needed Data

        // Get all first, in Case do Id is given
        $participants = $this->Participants->find('all', [
            'contain' => ['Timings', 'Codes'],
            'order' => 'Participants.id', 
            ])
            ->where(['submitdate IS NOT NULL']);
        // Filter if call is made with single ID
        if($id == null) {
            $participant =  $participants->first();
        } else {
            $participant = $this->Participants->get($id, [
                'contain' => ['Timings', 'Codes'],
            ]);
        }
        $codes = $this->Participants->Codes->find('all', [
            'contain' => ['FieldTypes']
        ])
        ->matching('FieldTypes')
        // TODO SORT BY NAME!
        ;
        $idsWhoFinished = $participants->extract('id')->toArray();

        // Data Saving Part
        if ($this->request->is(['patch', 'post', 'put'])) {
            $participant = $this->Participants->patchEntity($participant, $this->request->getData());
            if ($this->Participants->save($participant)) {
                $this->Flash->success(__('The participant has been saved.'));

                debug( $this->request);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The participant could not be saved. Please, try again.'));
        }

        $this->set([
            'participant' => $participant,
            'codes' => $codes,
            'idsWhoFinished' => $idsWhoFinished
        ]);
    }

    /**
     * Read Through Feeback method
     *
     * @param string|null $id Participant id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function readThroughFeedback($id = null)
    {

        $participants = $this->Participants->find('all', [
            'contain' => ['Timings', 'Codes'],
            'order' => 'Participants.id', 
            ])
            ->where(['submitdate IS NOT NULL']);
        
        $idsWhoFinished = $participants->extract('id')->toArray();
        if($id == null) {
            $participant =  $participants->first();
        } else {
            $participant = $this->Participants->get($id, [
                'contain' => ['Timings', 'Codes'],
            ]);
        }

        $this->set([
            'participant' => $participant,
            'idsWhoFinished' => $idsWhoFinished
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Participant id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $participant = $this->Participants->get($id);
        if ($this->Participants->delete($participant)) {
            $this->Flash->success(__('The participant has been deleted.'));
        } else {
            $this->Flash->error(__('The participant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
