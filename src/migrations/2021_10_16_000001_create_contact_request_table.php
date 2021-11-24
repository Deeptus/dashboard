<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::dropIfExists('contact_request');
        Schema::create('contact_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('company_code')->nullable(); // CUIT
            $table->string('phone')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->longText('message')->nullable();
            $table->longText('observation')->nullable();
            // purchase
            $table->double('shipping_price')->nullable(); // Envio
            $table->double('subtotal')->nullable(); // Descuentos calculado
            $table->string('discounts')->nullable(); // Descuentos: -1500,-30%,-150
            $table->double('discount')->nullable(); // Descuentos calculado
            $table->string('taxes')->nullable(); // Impuestos IVA 21%, simil a discounts
            $table->double('tax')->nullable(); // Impuestos calculado
            $table->double('total')->nullable(); // Total con descuentos y impuestos aplicado

            $table->unsignedBigInteger('ref_id')->nullable(); // reserved for user or customer(Cliente) ID
            $table->string('lang')->nullable(); // El idioma activo en el momento de la solicitud
            $table->string('type')->nullable(); // budget => 'Presupuesto', contact-message => 'Mensaje de contacto', shopping_cart => 'Carrito'
            $table->timestamp('read_at')->nullable();
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::dropIfExists('contact_request_file');
        Schema::create('contact_request_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->string('path')->nullable();
            $table->string('original_name')->nullable();
            $table->string('observation')->nullable();
            $table->unsignedBigInteger('contact_request_id')->references('id')->on('contact_request');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::dropIfExists('contact_request_items');
        Schema::create('contact_request_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->nullable();
            $table->unsignedBigInteger('ref_id')->nullable();
            // Product description
            $table->string('name')->nullable();
            $table->string('image_url')->nullable();
            $table->string('description')->nullable();
            $table->string('code')->nullable();
            $table->unsignedBigInteger('product_id')->unsigned()->nullable();
            $table->unsignedBigInteger('presentation_id')->unsigned()->nullable();
            $table->string('presentation')->nullable(); // Ej: Camisa, Negra, XL, etc
            // purchase info
            $table->unsignedBigInteger('price_list_id')->unsigned()->nullable();
            $table->double('base_price')->nullable(); // Precio sin nada aplicado
            $table->string('discounts')->nullable(); // Descuentos, -1500,-30%,-150
            $table->double('discount')->nullable(); // Descuentos calculado
            $table->string('taxes')->nullable(); // Impuestos IVA 21%, simil a discounts
            $table->double('tax')->nullable(); // Impuestos calculado
            $table->double('unit_price')->nullable(); // Precio con descuentos y impuestos aplicado
            $table->double('quantity')->nullable(); // Cantidad

            $table->unsignedBigInteger('contact_request_id')->references('id')->on('contact_request');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('contact_request_items');
        Schema::dropIfExists('contact_request_file');
        Schema::dropIfExists('contact_request');
    }
}
