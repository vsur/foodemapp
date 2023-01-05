<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Timings Controller
 *
 * @property \App\Model\Table\TimingsTable $Timings
 *
 * @method \App\Model\Entity\Timing[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TimingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $timings = $this->paginate($this->Timings);

        $this->set(compact('timings'));
    }

    /**
     * View method
     *
     * @param string|null $id Timing id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $timing = $this->Timings->get($id, [
            'contain' => ['Participants'],
        ]);

        $this->set('timing', $timing);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $timing = $this->Timings->newEntity();
        if ($this->request->is('post')) {
            $timing = $this->Timings->patchEntity($timing, $this->request->getData());
            if ($this->Timings->save($timing)) {
                $this->Flash->success(__('The timing has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The timing could not be saved. Please, try again.'));
        }
        $this->set(compact('timing'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Timing id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $timing = $this->Timings->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $timing = $this->Timings->patchEntity($timing, $this->request->getData());
            if ($this->Timings->save($timing)) {
                $this->Flash->success(__('The timing has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The timing could not be saved. Please, try again.'));
        }
        $this->set(compact('timing'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Timing id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $timing = $this->Timings->get($id);
        if ($this->Timings->delete($timing)) {
            $this->Flash->success(__('The timing has been deleted.'));
        } else {
            $this->Flash->error(__('The timing could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
