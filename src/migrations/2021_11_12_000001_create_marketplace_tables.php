<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateMarketplaceTables extends Migration {

    private $tables = [];
    private $tablesCrudeables = [];

    public function up() {
        // Vendedores
        Schema::create('marketplace_sellers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('username')->unique();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('website')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_sellers',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Sellers',
        ];
        $this->tablesCrudeables['marketplace_sellers'] = [];

        // tipo contribuyente
        Schema::create('marketplace_type_taxpayer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_type_taxpayer',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\TypeTaxpayer',
        ];
        $this->tablesCrudeables['marketplace_type_taxpayer'] = [];

        // Locations
        // Locations 1 => Provincias
        // Locations 2 => Localidades
        // Locations 3 => Barrios
        Schema::create('marketplace_locations_1', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_locations_1',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Locations1',
        ];
        $this->tablesCrudeables['marketplace_locations_1'] = [];
        
        Schema::create('marketplace_locations_2', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->bigInteger('location_1_id')->unsigned();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_locations_2',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Locations2',
        ];
        $this->tablesCrudeables['marketplace_locations_2'] = [];

        Schema::create('marketplace_locations_3', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->bigInteger('location_2_id')->unsigned();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_locations_3',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Locations3',
        ];
        $this->tablesCrudeables['marketplace_locations_3'] = [];

        Schema::create('marketplace_locations_4', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->bigInteger('location_3_id')->unsigned();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_locations_4',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Locations4',
        ];
        $this->tablesCrudeables['marketplace_locations_4'] = [];
        
        Schema::create('marketplace_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('username')->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('website')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('state')->default('unverified');// unverified, verified, banned
            $table->bigInteger('type_taxpayer_id')->unsigned()->nullable();
            $table->bigInteger('seller_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('type_taxpayer_id')->references('id')->on('marketplace_type_taxpayer')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('marketplace_sellers')->onDelete('cascade');
        });
        $this->tables[] = [
            'tablename' => 'marketplace_clients',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Clients',
        ];
        $this->tablesCrudeables['marketplace_clients'] = [];

        Schema::create('marketplace_clients_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->bigInteger('client_id')->unsigned();
            $table->string('key');
            $table->string('value');
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('marketplace_clients')->onDelete('cascade');
        });
        $this->tables[] = [
            'tablename' => 'marketplace_clients_meta',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\ClientsMeta',
        ];
        
        Schema::create('marketplace_client_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->bigInteger('client_id')->unsigned();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('business_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('dni')->nullable();
            $table->string('cuit')->nullable();
            $table->bigInteger('country')->unsigned()->nullable();

            $table->bigInteger('location_1_id')->unsigned()->nullable();
            $table->string('location_1_name')->nullable();

            $table->bigInteger('location_2_id')->unsigned()->nullable();
            $table->string('location_2_name')->nullable();

            $table->bigInteger('location_3_id')->unsigned()->nullable();
            $table->string('location_3_name')->nullable();

            $table->bigInteger('location_4_id')->unsigned()->nullable();
            $table->string('location_4_name')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('marketplace_clients')->onDelete('cascade');
            $table->foreign('location_1_id')->references('id')->on('marketplace_locations_1')->onDelete('cascade');
            $table->foreign('location_2_id')->references('id')->on('marketplace_locations_2')->onDelete('cascade');
            $table->foreign('location_3_id')->references('id')->on('marketplace_locations_3')->onDelete('cascade');
            $table->foreign('location_4_id')->references('id')->on('marketplace_locations_4')->onDelete('cascade');
        });
        $this->tables[] = [
            'tablename' => 'marketplace_client_profiles',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\ClientProfiles',
        ];

        Schema::create('marketplace_warehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_warehouses',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Warehouses',
        ];
        $this->tablesCrudeables['marketplace_warehouses'] = [];

        Schema::create('marketplace_price_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_price_list',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\PriceList',
        ];
        $this->tablesCrudeables['marketplace_price_list'] = [];

        Schema::create('marketplace_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_categories',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Categories',
        ];
        $this->tablesCrudeables['marketplace_categories'] = [];

        Schema::create('marketplace_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_tags',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Tags',
        ];
        $this->tablesCrudeables['marketplace_tags'] = [];
        
        /// Distintos tipos de layout para formatos de productos ///
        Schema::create('marketplace_layouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_layouts',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Layouts',
        ];
        ///Esto esta pendiente de funcionamiento

        Schema::create('marketplace_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('layout_slug')->nullable();
            $table->unsignedBigInteger('category_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('marketplace_categories')->onDelete('cascade');
        });
        $this->tables[] = [
            'tablename' => 'marketplace_products',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Products',
        ];
        $this->tablesCrudeables['marketplace_products'] = [];

        Schema::create('marketplace_presentations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->unsignedBigInteger('product_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('marketplace_products')->onDelete('cascade');
        });
        $this->tables[] = [
            'tablename' => 'marketplace_presentations',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Presentations',
        ];

        Schema::create('marketplace_presentation_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('presentation_id')->unsigned();
            $table->unsignedBigInteger('price_list_id')->unsigned();
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('presentation_id')->references('id')->on('marketplace_presentations')->onDelete('cascade');
            $table->foreign('price_list_id')->references('id')->on('marketplace_price_list')->onDelete('cascade');
        });
        $this->tables[] = [
            'tablename' => 'marketplace_presentation_prices',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\PresentationPrices',
        ];

        Schema::create('marketplace_presentation_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('presentation_id')->unsigned();
            $table->unsignedBigInteger('warehouse_id')->unsigned();
            $table->float('stock');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('presentation_id')->references('id')->on('marketplace_presentations')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('marketplace_warehouses')->onDelete('cascade');
        });
        $this->tables[] = [
            'tablename' => 'marketplace_presentation_stocks',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\PresentationStocks',
        ];
        
        Schema::create('marketplace_environments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_environments',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Environments',
        ];
        DB::table('marketplace_environments')->insert([
            ['name' => 'Sitio Web', 'slug' => 'website'],
            ['name' => 'Area de Clientes', 'slug' => 'customers'],
            ['name' => 'Area de Proveedores', 'slug' => 'providers'],
        ]);
        Schema::create('marketplace_visibilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
        $this->tables[] = [
            'tablename' => 'marketplace_visibilities',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\Visibilities',
        ];

        DB::table('marketplace_visibilities')->insert([
            ['name' => 'Mostar', 'slug' => 'show'],
            ['name' => 'Botón de compra', 'slug' => 'buy_button'],
            ['name' => 'Botón de consulta', 'slug' => 'consult_button'],
            ['name' => 'Sin stock', 'slug' => 'no_stock'],
        ]);
        Schema::create('marketplace_product_visibilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('environment_id');
            $table->unsignedBigInteger('visibility_id');
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('marketplace_products')->onDelete('cascade');
            $table->foreign('environment_id')->references('id')->on('marketplace_environments')->onDelete('cascade');
            $table->foreign('visibility_id')->references('id')->on('marketplace_visibilities')->onDelete('cascade');
        });
        $this->tables[] = [
            'tablename' => 'marketplace_product_visibilities',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\ProductVisibilities',
        ];

        /**
         * Ejemplo de uso:
         * | Visibility        | Sitio Web | Area de Clientes | Area de Proveedores |
         * | Mostar            | Si        | Si               | Si                  |
         * | Botón de compra   | Si        | Si               | No                  |
         * | Botón de consulta | No        | Si               | Si                  |
         * | Sin stock         | No        | No               | No                  |
         */

        Schema::create('marketplace_product_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->unsigned();
            $table->unsignedBigInteger('category_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('marketplace_products')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('marketplace_categories')->onDelete('cascade');
        });
        $this->tables[] = [
            'tablename' => 'marketplace_product_categories',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\ProductCategories',
        ];

        Schema::create('marketplace_product_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->unsigned();
            $table->unsignedBigInteger('tag_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('marketplace_products')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('marketplace_tags')->onDelete('cascade');
        });
        $this->tables[] = [
            'tablename' => 'marketplace_product_tags',
            'crudeable' => true,
            'model' => 'AporteWeb\Dashboard\Models\Marketplace\ProductTags',
        ];
        Storage::put('tables.json', json_encode($this->tables, JSON_PRETTY_PRINT));
        foreach ($this->tables as $table) {
            $comment = 'DASHBOARD_MARKETPLACE_TABLE_RESPECT_BASE_STRUCTURE';
            DB::statement("ALTER TABLE `" . $table['tablename'] . "` comment '$comment'");
            if (array_key_exists($table['tablename'], $this->tablesCrudeables)) {
                $columns = Schema::getColumnListing($table['tablename']);
                $dirPath = __crudFolder();
    
                $data = [
                    "table" => [
                        "id" => 1,
                        "single_record" => "0",
                        "translation_method" => "none",
                        "uuid" => 1,
                        "order_index" => 0,
                        "tablename" => $table['tablename'],
                        //"name" => [
                        //    "es" => "Datos de la empresa"
                        //],
                        "timestamps" => 1,
                        "softDeletes" => 1,
                        //"slug" => 0,
                        //"slug_col" => "",
                        //"slug_global" => 0,
                        //"is_authenticatable" => 0,
                        "ignore_columns" => implode(',', $columns),
                        "model" => $table['model'],
                    ],
                    "inputs" => [],
                    "conditions" => []
                ];
                $filePath = $dirPath . '/' . $table['tablename'] . '.json';
                file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
            }
        }
    }

    public function down() {
        $this->tables = json_decode(Storage::get('tables.json'), true);
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($this->tables as $table) {
            Schema::dropIfExists($table['tablename']);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
