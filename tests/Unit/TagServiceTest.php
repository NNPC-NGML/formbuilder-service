<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Jobs\Tag\TagCreated;
use App\Services\TagService;
use Illuminate\Foundation\Testing\RefreshDatabase;



class TagServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_to_ensure_a_tag_can_be_created()
    {
        // create Data
        $data = ["name" => "test"];
        $this->assertDatabaseMissing("tags", $data);
        $response = $this->tagService()->createNewTag($data);
        $this->assertDatabaseHas("tags", $data);
        $this->assertTrue($response);
    }

    public function test_to_ensure_a_tag_name_is_unique()
    {
        // create Data
        $data = ["name" => "test"];
        $this->tagService()->createNewTag($data);
        $this->assertDatabaseCount("tags", 1);
        $response = $this->tagService()->createNewTag($data);
        $this->assertDatabaseCount("tags", 1);
        $this->assertFalse($response);
    }

    public function test_to_ensure_a_tag_can_be_created_from_job()
    {
        // create Data
        $data = ["name" => "test"];
        $this->assertDatabaseMissing("tags", $data);
        $job = new TagCreated($data);
        $job->handle();
        $this->assertDatabaseHas("tags", $data);
    }

    public function test_to_ensure_a_tag_name_is_unique_from_job()
    {
        // create Data
        $data = ["name" => "test"];
        $this->tagService()->createNewTag($data);
        $this->assertDatabaseCount("tags", 1);
        $job = new TagCreated($data);
        $job->handle();
        $this->assertDatabaseCount("tags", 1);
    }

    private function tagService()
    {
        return new TagService();
    }
}
