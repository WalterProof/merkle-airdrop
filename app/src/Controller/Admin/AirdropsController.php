<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Airdrops Controller
 *
 * @property \App\Model\Table\AirdropsTable $Airdrops
 * @method   \App\Model\Entity\Airdrop[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AirdropsController extends AppController
{
    public function index(): void
    {
        $query = $this->Airdrops->find();
        if ($q = $this->request->getQuery('q')) {
            $q = trim($q);
            $query = $query->where(['name LIKE' => "%{$q}%"]);
        }
        $airdrops = $this->paginate($query);
        $this->set(compact('airdrops', 'q'));

        if ($this->isHTMXRequest()) {
            $this->viewBuilder()
                ->setLayout('ajax')
                ->setTemplate('list');
        }
    }

    public function view(?string $id = null): void
    {
        $airdrop = $this->Airdrops->get($id, contain: ['Tokens', 'Recipients']);

        $this->set(compact('airdrop'));
    }

    public function add()
    {
        $airdrop = $this->Airdrops->newEmptyEntity();
        if ($this->request->is('post')) {
            $airdrop = $this->Airdrops->patchEntity($airdrop, $this->request->getData());
            if ($this->Airdrops->save($airdrop)) {
                $this->Flash->success(__('The airdrop has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The airdrop could not be saved. Please, try again.'));
        }
        $tokens = $this->Airdrops->Tokens->find('list', ['limit' => 200])->all();
        $recipients = $this->Airdrops->Recipients->find('list', ['limit' => 200])->all();
        $this->set(compact('airdrop', 'tokens', 'recipients'));
    }

    public function edit(?string $id = null)
    {
        $airdrop = $this->Airdrops->get($id, contain: ['Recipients']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $airdrop = $this->Airdrops->patchEntity($airdrop, $this->request->getData());
            if ($this->Airdrops->save($airdrop)) {
                $this->Flash->success(__('The airdrop has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The airdrop could not be saved. Please, try again.'));
        }
        $tokens = $this->Airdrops->Tokens->find('list', ['limit' => 200])->all();
        $recipients = $this->Airdrops->Recipients->find('list', ['limit' => 200])->all();
        $this->set(compact('airdrop', 'tokens', 'recipients'));
    }

    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $airdrop = $this->Airdrops->get($id);
        if ($this->Airdrops->delete($airdrop)) {
            $this->Flash->success(__('The airdrop has been deleted.'));
        } else {
            $this->Flash->error(__('The airdrop could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}