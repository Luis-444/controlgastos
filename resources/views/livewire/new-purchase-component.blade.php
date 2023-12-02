<x-normal-layout>
    <div class="flex flex-col h-full overflow-hidden"
        x-data="{
            'products': [],
            'error_quantities': [],
            'error_prices': [],
            'taxes': [],
            'subTotal': 0,
            'taxAmount': 0,
            'total': 0,
            'removed_products': [],
            'selectedFiles': [],
            removeDetail(id, index){
                if(id){
                    $wire.productDetailRemove(id);
                }
                this.products.splice(index, 1);
            },
            removeMedia(id, index){
                if(id){
                    $wire.mediaRemove(id);
                }
                this.selectedFiles.splice(index, 1);
            },
            formatAmount(amount){
                return amount.toLocaleString('es-Mx', { minimumFractionDigits: 2 });
            },
            calculateAmount(index){
                this.products[index].amount = this.products[index].product.price * this.products[index].quantity;
                this.calculateSubTotal();
            },
            calculateSubTotal(){
                this.subTotal = this.products.reduce((total, product) => total + product.amount, 0);
                this.taxAmount = this.products.reduce((total, product) => total + product.amount * product.percentage / 100, 0);
            },
            setTaxToDetail(index){
                this.products[index].percentage = this.taxes.filter(tax => { return tax.id == this.products[index].tax_id})[0].percentage;
            }
        }"
        x-init="
            $wire.on('addProduct', (product)=> {
                const detail = {
                    product:product,
                    quantity:null,
                    price:null,
                    tax:product.tax,
                    tax_id:product.tax_id,
                    percentage:product.tax.percentage,
                    tax_amount:null,
                    amount:0,
                    subtotal:null,
                    total_tax:null,
                    total:null,
                }
                products.unshift(detail);
                console.log(product);
            });
            $wire.on('erase', ()=>{
                products=[];
            });
            $wire.on('setproducts', (partTemplateDetails)=> {
                products=partTemplateDetails;
            })
            $wire.on('setTaxes', (all_taxes)=> {
                taxes=all_taxes;
            })
            $wire.on('savePurchase', ()=> {
                error_quantities = [];
                error_prices = [];
                if(!products.length){
                    $wire.emit('showNotification', 'Ingresa al menos un producto', '#880000');
                    return;
                }
                let error = false;
                products.forEach((detail, index)=>{
                    if(!detail.quantity){
                        error= true;
                        error_quantities.push(index);
                    }
                    if(!detail.product.price){
                        error= true;
                        error_prices.push(index);
                    }
                })
                if(!error){
                    $wire.validatePurchase();
                }else{
                    $wire.emit('showNotification', 'Verifica los campos marcados', '#880000');
                }
            })
            $wire.getTaxes();
        ">
        <x-slot name="actionSlot">
            <x-button class="button-danger" wire:click="erase" onclick="window.location.href = '/compra';">
                Cancelar
            </x-button>
            <x-button class="button-primary" wire:click="$emit('savePurchase')">
                Guardar
            </x-button>
        </x-slot>
        <div class="flex items-end justify-between">
            <div class="flex space-x-2 items-end">
                <x-full-input-component label="Folio" for="folio" wire:model="folio"/>
                <x-full-select-component default_option="Selecciona un proveedor" wire:model="supplier_id" for="supplier_id" :items="$suppliers"/>
            </div>
            <div class="w-1/3">
                <x-full-input-component label="Fecha" type='datetime-local' for="date" wire:model="date"/>
            </div>
        </div>
        <x-full-area-component label="Descripción" for="notes" wire:model="notes" />
        <x-full-input-component input_id="media_id" label="Subir comprobante" for="media" wire:model="media" type="file" multiple/>
        <div class="flex__container space-x-2 pt-3">
            @foreach ($media as $m)
                @if(in_array($m->getClientOriginalExtension(), $img_extensions))
                    <img class="w-10 aspect-square rounded-md" src="{{ $m->temporaryUrl() }}" alt="">
                @else
                    <div class="rounded-md border border-cyan-600 text-primary p-2 flex__container space-x-2">
                        <x-icons.pdf/>
                        <span>{{ $m->getClientOriginalName() }}</span>
                        <x-icons.trash class="text-black icon__pointer" wire:click="export()"/>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="input__select__container pt-3"
            x-data="{
                'select_index': 0,
                'selected_id': null,
                'onInput': false,
                resetIndex(){
                    this.select_index = 0;
                    this.selected_id = null;
                },
                changeIndex(keyCode, max_parts){
                    container = document.getElementById('#select__container__products');
                    if(keyCode == 40 && this.select_index < max_parts - 1){
                        this.select_index += 1;
                        select__container__products.scrollTop += 50;
                    }
                    else if(keyCode == 38 && this.select_index > 0){
                        this.select_index -= 1;
                        select__container__products.scrollTop -= 50;
                    }
                }
            }">
            <div class="pb-6">
                <x-full-input-component x-on:focus="onInput = true" x-on:click="onInput = true" @click.away="onInput = false" x-on:keyup.enter="$wire.addProductForIndex(select_index); resetIndex()" x-on:keyup="changeIndex($event.keyCode, {{count($productsfind)}})" class="input" wire:keyup="searchProduct" wire:model="productSearch" placeholder="Nombre" label="Ingresa el nombre del producto o servicio"/>
                @if (count($productsfind))
                    <div x-show="onInput" x-transition id="select__container__products" class="select__container">
                        @foreach ($productsfind as $key => $pf)
                            <span x-on:click="resetIndex()" wire:click="addProduct({{$pf->id}})" class="select__option" :class="select_index == {{ $key }} ? 'select__option__active' : ''">
                                {{-- <img class="img__circle" src="{{ $pf->img ? '/storage'.$pf->img : '/imgs/default_part.png' }}"> --}}
                                <span>{{ $pf->category->name }} - {{ $pf->name }}</span>
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="flex-1 overflow-auto">
            <table
                x-show="products.length"
                class="table">
                <thead>
                    <tr>
                        <th class="w-1/12">Accion</th>
                        <th class="w-4/12">Producto</th>
                        <th class="w-1/12">Cantidad</th>
                        <th class="w-1/12">Precio</th>
                        <th class="w-1/12">Impuestos</th>
                        <th class="w-1/12">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="detail, index in products">
                        <tr>
                            <td>
                                <div class="flex__container__center">
                                    <x-icons.trash class="icon__pointer" x-on:click="removeDetail(detail.id, index)"/>
                                </div>
                            </td>
                            <td>
                                <span x-text="detail.product.name"></span>
                            </td>
                            <td>
                                <input x-on:keyup='calculateAmount(index)' type="number" x-model="detail.quantity" class="input" :class="error_quantities.includes(index) ? 'border border-red-500 bg-red-200' : '' " min="0" max="30">
                            </td>
                            <td>
                                <input x-on:keyup='calculateAmount(index)' type="number" x-model="detail.product.price" class="input" :class="error_prices.includes(index) ? 'border border-red-500 bg-red-200' : '' ">
                            </td>
                            <td>
                                <x-full-select-component x-model="detail.tax_id" x-on:change="setTaxToDetail(index)" for="tax_id" :items="$taxes"/>
                            </td>
                            <td class="text-end" >
                                <span x-text="'$' +formatAmount(detail.amount)"></span>
                            </td>
                        </tr>
                    </template>
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-end" >Subtotal</td>
                        <td class="text-end" x-text="'$' +formatAmount(subTotal)"></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-end" >Impuestos</td>
                        <td class="text-end" x-text="'$' +formatAmount(taxAmount)"></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-end" >Total</td>
                        <td class="text-end" x-text="'$' + formatAmount(subTotal + taxAmount)"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <x-dialog-modal wire:model="confirmationSaveModal">
            <x-slot name="title">
                Confirmar
            </x-slot>
            <x-slot name="content">
                <div class="flex__container space-x-2">
                    <x-icons.warning class="text-warning w-10"/>
                    <span>¿Estas seguro de guardar esta compra?</span>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-button class="button-primary" x-on:click="$wire.savePurchase(products, taxAmount)">
                    Aceptar
                </x-button>
                <x-button class="button-danger" wire:click="$set('confirmationSaveModal', false)">
                    Cancelar
                </x-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</x-normal-layout>
