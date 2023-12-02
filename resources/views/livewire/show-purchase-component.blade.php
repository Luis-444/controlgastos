<x-normal-layout>
    <div class="h-full"
        x-data="{
            'products': [],
            'taxes': [],
            'subTotal': 0,
            'taxAmount': 0,
            'total': 0,
            'removed_products': [],
            removeDetail(id, index){
                if(id){
                    $wire.productDetailRemove(id);
                }
                this.products.splice(index, 1);
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
                    amount:null,
                    subtotal:null,
                    total_tax:null,
                    total:null,
                }
                products.push(detail);
                console.log(product);
            });
            $wire.on('erase', ()=>{
                products=[];
            $wire.on('setTaxes', (all_taxes)=> {
                taxes=all_taxes;
            })
            $wire.getTaxes();
        ">
        <x-slot name="actionSlot">
            <x-button class="button-primary" onclick="window.location.href = '/compra';">
                Regresar
            </x-button>
        </x-slot>
        <div class="">
            <div class="flex items-end justify-between">
                <div class="flex space-x-2 items-end">
                    <x-full-input-component label="Folio" value="{{$purchase->folio}}" disabled/>
                    <x-full-input-component  label="Proveedor" value="{{$purchase->supplier->name}}" disabled/>
                </div>
                <div class="w-1/3">
                    <x-full-input-component label="Fecha" type='datetime-local' value="{{$date}}" disabled/>
                </div>
            </div>
            <x-full-area-component label="Descripción" value="{{$purchase->notes}}" disabled/>
            <div class="flex__container flex-wrap gap-2 pt-3">
                @foreach ($media as $m)
                    @if(in_array(substr($m->path, -3), $img_extensions))
                        <img class="w-10 aspect-square rounded-md" src="/storage/PurchaseMedia/Purchase-1-1697485296-1.jpg" alt="">
                        @dump($m->path)
                    @else
                        <div class="rounded-md border border-cyan-600 text-primary p-2 flex__container space-x-2">
                            <x-icons.pdf/>
                            <span>{{ $m->name }}</span>
                            <x-icons.download class="text-black icon__pointer" wire:click="export('{{ $m->path }}', '{{ $m->name }}')"/>
                        </div>
                    @endif
                @endforeach
            </div>
            {{-- Aqui iran los archivos que fueron subidos --}}
            <div class="input__select__container pt-4"
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
                <table
                    class="table">
                    <thead>
                        <tr>
                            <th class="w-4/12">Producto</th>
                            <th class="w-1/12">Cantidad</th>
                            <th class="w-1/12">Precio</th>
                            <th class="w-1/12">Impuestos</th>
                            <th class="w-1/12">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchase->purchase_details as $key => $pd)
                            <tr>
                                <td>{{$pd->name}}</td>
                                <td>{{$pd->quantity}}</td>
                                <td>${{$pd->price}}</td>
                                <td>{{$pd->purchase_detail_tax->tax->name}}</td>
                                <td class="text-end" >${{$pd->amount}}</td>
                            </tr>
                        @endforeach
                        <tr class="border-t border-black">
                            <td colspan="3"></td>
                            <td class="text-end">Subtotal:</td>
                            <td class="text-end" >${{ $purchase->getSubtotal() }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-end" >Impuestos:</td>
                            <td class="text-end" >${{ $purchase->getTaxAmount() }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-end" >Total:</td>
                            <td class="text-end" >${{$purchase->getTotal()}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-normal-layout>

