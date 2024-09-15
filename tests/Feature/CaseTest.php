<?php

use App\Models\Cas;
use App\Models\User;
use App\Models\Client;
use App\Models\Court;
use App\Models\Judge;
use Illuminate\Foundation\Testing\RefreshDatabase;

describe("testing case controller", function() {

    it('has case screen with valid data', function(){
        $user = User::factory()->create(); 
        $this->actingAs($user);

        Client::factory(5)->create();
        Court::factory(5)->create();
        Judge::factory(5)->create();

        $case = Cas::factory(5)->create();
        $res = $this->get('/cas');


        $res->assertViewIs('dashboard-cases');

        $res->assertViewHas('cas', function($cases) use ($case){
            return $cases->first()->is($case->first());
        });

        $res->assertStatus(200);
    });

    it('get all cases in json format', function(){
        $user = User::factory()->create(); 
        $this->actingAs($user);

        $cas = Client::factory(5)->create();
        $cas = Court::factory(5)->create();
        $cas = Judge::factory(5)->create();

        $case = Cas::factory()->create();
        $res = $this->get('/caseJson');

        $res->assertHeader('Content-Type', 'application/json');
        $res->assertJsonStructure([]);
        $res->assertStatus(200);
    });

    it("show a case screen to create one", function(){
       $user = User::factory()->create();
       $this->actingAs($user);

       $res = $this->get('/case-add');

       $res->assertViewIs('cases.add-cas');
    });

    it("create new Case with procedure", function(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $court = Court::factory()->create();
        $client = Client::factory()->create();
        $judge = Judge::factory()->create();

        $data = [
            'serial_number' => '213/221',
            'court'=> $court->id,
            'client' => $client->id,
            'title_file' => "jarimat 9atel",
            'title_number' => "123/2131",
            'judge' => $judge->id,
            'report_file' => 'idono what this file is all about ??',
            'execution_file' => "same as this file",
            'report_number' => "12/312",
            'execution_number' => "3241/423",
            'opponent' => "sbira",
            'status' => 'Open',
            'time' => now()->format('H:i:s'),
            'date' => now()->format('Y-m-d'),
            'procedure' => "this procedure is a fraud",
            'invoice' => 150,
            'fee' => 1000
        ];

        $res = $this->post("/store-case", $data);


        $res->assertStatus(302);
        $res->assertRedirect('/cas');

    });


    it("create new Case without procedure", function(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $court = Court::factory()->create();
        $client = Client::factory()->create();
        $judge = Judge::factory()->create();

        $data = [
            'serial_number' => '213/221',
            'court'=> $court->id,
            'client' => $client->id,
            'title_file' => "jarimat 9atel",
            'title_number' => "123/2131",
            'judge' => $judge->id,
            'report_file' => 'idono what this file is all about ??',
            'execution_file' => "same as this file",
            'report_number' => "12/312",
            'execution_number' => "3241/423",
            'opponent' => "sbira",
            'status' => 'Open',
        ];

        $res = $this->post("/store-case", $data);

        $res->assertStatus(302);
        $res->assertRedirect('/cas');

    });

    it("faild when ceating new Case", function(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $court = Court::factory()->create();
        $client = Client::factory()->create();
        $judge = Judge::factory()->create();

        $data = [
            'title_number' => "123/2131",
            'report_file' => 'idono what this file is all about ??',
            'execution_file' => "same as this file",
            'report_number' => "12/312",
            'execution_number' => "3241/423",
            'opponent' => "sbira",
            'status' => 'Open',
        ];

        $res = $this->post("/store-case", $data);

        $res->assertSessionHasErrors(['client', 'serial_number', 'judge', 'court', 'title_file']);
        $res->assertStatus(302);

    });

    it('show view screen with case data', function(){
        $user = User::factory()->create();
        $this->actingAs($user);

        Client::factory(5)->create();
        Court::factory(5)->create();
        Judge::factory(5)->create();

        $case = Cas::factory()->create();

        $res = $this->get('cas/'. $case->id);

        $res->assertViewIs('cases.show-cas');
        $res->assertViewHas('case', function($cases) use ($case){
            return $cases->first()->is($case->first());
        });

    });

    it("show sceen for updating case", function(){
        $user = User::factory()->create();
        $this->actingAs($user);


        $client = Client::factory(5)->create();
        $court = Court::factory(5)->create();
        $judge =Judge::factory(5)->create();

        $case = Cas::factory()->create();

        $res = $this->get('case-edit/'. $case->id);

        $res->assertViewIs('cases.edit-cas');
        $res->assertViewHas('case', function($cases) use ($case){
            return $cases->first()->is($case->first());
        });
        $res->assertViewHas('clients', function($cl) use ($client){
            return $cl->first()->is($client->first());
        });
        $res->assertViewHas('judges', function($jd) use ($judge){
            return $jd->first()->is($judge->first());
        });
        $res->assertViewHas('court', function($ct) use ($court){
            return $ct->first()->is($court->first());
        });
    });


    it("edit a Case", function(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $court = Court::factory()->create();
        $client = Client::factory()->create();
        $judge = Judge::factory()->create();
        
        $case = Cas::factory()->create();

        $data = [
            'serial_number' => '213/221',
            'court'=> $court->id,
            'client' => $client->id,
            'title_file' => "jarimat 9atel",
            'title_number' => "123/2131",
            'judge' => $judge->id,
            'report_file' => 'idono what this file is all about ??',
            'execution_file' => "same as this file",
            'report_number' => "12/312",
            'execution_number' => "3241/423",
            'opponent' => "sbira",
            'status' => 'Open',
        ];

        $res = $this->post("case-update/". $case->id , $data);

        $res->assertRedirect();
        $res->assertStatus(302);

    });

    it("faild to edit a Case", function(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $court = Court::factory()->create();
        $client = Client::factory()->create();
        $judge = Judge::factory()->create();
        
        $case = Cas::factory()->create();

        $data = [
            'title_file' => "jarimat 9atel",
            'title_number' => "123/2131",
            'report_file' => 'idono what this file is all about ??',
            'execution_file' => "same as this file",
            'report_number' => "12/312",
            'execution_number' => "3241/423",
            'opponent' => "sbira",
            'status' => 'Open',
        ];

        $res = $this->post("case-update/". $case->id , $data);

        $res->assertSessionHasErrors(['client', 'judge', 'court']);
        $res->assertStatus(302);

    });

    it("destory many cases", function(){
        $user = User::factory()->create();
        $this->actingAs($user);

        Court::factory(6)->create();
        Client::factory(8)->create();
        Judge::factory(8)->create();
        
        $case = Cas::factory(5)->create();

        $data = [
            "ids" => array($case[0]->id, $case[1]->id, $case[2]->id, $case[3]->id, $case[4]->id)
        ];

        $res = $this->delete('destroyMany-case', $data);

        $res->assertStatus(200);
    });

    it("delete a case", function(){
        $user = User::factory()->create();
        $this->actingAs($user);

        Court::factory(6)->create();
        Client::factory(8)->create();
        Judge::factory(8)->create();
        
        $case = Cas::factory()->create();


        $res = $this->delete('case-delete/'. $case->id);

        $res->assertStatus(200);
    });

    it("change status of a case", function(){
        $user = User::factory()->create();
        $this->actingAs($user);

        Court::factory()->create();
        Client::factory()->create();
        Judge::factory()->create();
        
        $case = Cas::factory()->create();

        $data = [
            "status" => "Closed"
        ];
        $res = $this->post('status/'. $case->id, $data);

        $res->assertStatus(200);
    });
});
