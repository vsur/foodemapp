<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ParticipantsCodes Controller
 *
 * @property \App\Model\Table\ParticipantsCodesTable $ParticipantsCodes
 *
 * @method \App\Model\Entity\ParticipantsCode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ParticipantsCodesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Participants', 'Codes'],
        ];
        $participantsCodes = $this->paginate($this->ParticipantsCodes);

        $this->set(compact('participantsCodes'));
    }

    /**
     * View method
     *
     * @param string|null $id Participants Code id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $participantsCode = $this->ParticipantsCodes->get($id, [
            'contain' => ['Participants', 'Codes'],
        ]);

        $this->set('participantsCode', $participantsCode);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $participantsCode = $this->ParticipantsCodes->newEntity();
        if ($this->request->is('post')) {
            debug($this->request);
            $participantsCode = $this->ParticipantsCodes->patchEntity($participantsCode, $this->request->getData());
            if ($this->ParticipantsCodes->save($participantsCode)) {
                $this->Flash->success(__('The participants code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The participants code could not be saved. Please, try again.'));
        }
        $participants = $this->ParticipantsCodes->Participants->find('list', ['limit' => 200]);
        $codes = $this->ParticipantsCodes->Codes->find('list', ['limit' => 200]);
        $this->set(compact('participantsCode', 'participants', 'codes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Participants Code id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $participantsCode = $this->ParticipantsCodes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $participantsCode = $this->ParticipantsCodes->patchEntity($participantsCode, $this->request->getData());
            if ($this->ParticipantsCodes->save($participantsCode)) {
                $this->Flash->success(__('The participants code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The participants code could not be saved. Please, try again.'));
        }
        $participants = $this->ParticipantsCodes->Participants->find('list', ['limit' => 200]);
        $codes = $this->ParticipantsCodes->Codes->find('list', ['limit' => 200]);
        $this->set(compact('participantsCode', 'participants', 'codes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Participants Code id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $participantsCode = $this->ParticipantsCodes->get($id);
        if ($this->ParticipantsCodes->delete($participantsCode)) {
            $this->Flash->success(__('The participants code has been deleted.'));
        } else {
            $this->Flash->error(__('The participants code could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
