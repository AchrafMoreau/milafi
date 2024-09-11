<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


describe("testing client controller" , function() {

    it('has client page and return the correct data', function () {
    
        $user = User::factory()->create(); 
        $this->actingAs($user);

        $client = Client::factory(5)->create();
        $res = $this->get('/client');
        $res->assertViewIs('dashboard-clients');

        $res->assertViewHas('clients', function($viewCases) use ($client){
            return $viewCases->first()->is($client->first());
        });

        $res->assertStatus(200);
    });

    it('create new client', function(){

        $user = User::factory()->create(); 
        $this->actingAs($user);

        $data = [
            'name' => 'Achraf',
            'contact_info' => '0674548461',
            'gender' => 'male',
            'CIN' => '292Ja1s',
            'address' => 'guelmim oudNoun',
        ];

        $res = $this->post('/store-client', $data);

        $res->assertStatus(201);
        // $this->assertDatabaseHas('clients', [
        //     'name' => $data['name'],
        //     'contact_info' => $data['contact'],
        //     'address' =>  $data['address'],
        //     'gender' => $data['gender'],
        //     'CIN' => $data['CIN'],
        // ]);

        expect(Client::latest()->first())
            ->name->toBe($data['name'])
            ->CIN->toBe($data['CIN'])
            ->gender->toBe($data['gender'])
            ->address->toBe($data['address'])
            ->contact_info->toBe($data['contact_info']);
    });


    it('faild to create new Client with invalid data', function(){

        $user = User::factory()->create(); 
        $this->actingAs($user);

        $data = [
            'name' => '',
            'CIN' => '',
            'gender' => 854,
            'contact_info' => 15,
        ];

        $res = $this->post('/store-client', $data);

        $res->assertSessionHasErrors(['name', 'CIN', 'contact_info', 'gender']);
        $res->assertStatus(302);
    });

    it('show client page and return the client data', function(){

        $user = User::factory()->create(); 
        $this->actingAs($user);

        $client = Client::factory()->create();

        $res = $this->get('/client'. '/' . $client->id);

        $res->assertViewIs('clients.show-client');
        $res->assertViewHas('client', function($viewCases) use ($client){
            return $viewCases->first()->is($client->first());
        });
        
    });

    it('update client', function(){

        $user = User::factory()->create(); 
        $this->actingAs($user);

        $client = Client::factory()->create();
        $data = [
            'name' => 'karim',
            'contact_info' => '023012033',
            'gender' => 'male',
            'CIN' => 'ja12345'
        ];
        $res = $this->put('/client' . '/' . $client->id, $data);

        $res->assertStatus(200);

        expect(Client::latest()->first())
            ->name->toBe($data['name'])
            ->contact_info->toBe($data['contact_info'])
            ->gender->toBe($data['gender'])
            ->CIN->toBe($data['CIN']);
        
    });

    it('faild to update client with invalid data', function(){

        $user = User::factory()->create(); 
        $this->actingAs($user);

        $client = Client::factory()->create();
        $data = [
            'name' => '',
            'contact_info' => 123,
            'gender' => 123,
            'CIN' => ''
        ];
        $res = $this->put('/client' . '/' . $client->id, $data);

        $res->assertSessionHasErrors(['name', 'CIN', 'contact_info', 'gender']);
        $res->assertStatus(302);
        
    });

    it('deleted client', function(){

        $user = User::factory()->create(); 
        $this->actingAs($user);

        $client = Client::factory()->create();

        $res = $this->delete('/client'. '/'. $client->id);

        expect(Client::find($client->id))
            ->id->toBe(null);

        $res->assertStatus(302);
    });
});
