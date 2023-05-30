<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Console\Command;

class ElasticLogSetup extends Command
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:log_setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup elastic log index';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        parent::__construct();
    }


    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function handle()
    {
        $index = rtrim(config('elastic_log.suffix'), '_') . '_' . config('elastic_log.index');

        if (!$this->client->indices()->exists(['index' => $index])) {
            $this->client->indices()->create([
                'index' => $index,
            ]);
        }
    }
}
