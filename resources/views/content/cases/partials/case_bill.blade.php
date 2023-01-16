
  <div class="row content_bill_data" >
    <div class="col-md-3">
      <button class="btn btn-primary btn-sm btn-block btnAddbillCase"  id="btnAddBillCase"><i class="fas fa-donate"></i> Agregar cobro</button>
    </div>
    <div class=" col-md-3 offset-md-4 ">
      <i class="fas fa-calculator"></i> <b>Valor total:</b> <span id="lbl_get_total_payments">{{number_format($case->getTotalPayments(),0,'.','.')}}</span> 
    </div>
    <div class=" col-md-2 ">
      <i class="fas fa-calculator"></i> <b>Saldo:</b> <span id="lbl_get_balance_payments">{{number_format($case->getBalancePayments(),0,'.','.')}}</span>
    </div>
  </div>

  <div class="row content_bill_data" id="content_bill_data">
    <div class="col-md-12 table-responsive p-0">
        <table class="table content_list_bills table-striped" id="table_list_bills">
          <thead>
            <tr>
              <th>
                Fecha 
              </th>
              <th>
                Categoria
              </th>
              <th>
                Concepto
              </th>
              <th>
                Tipo pago
              </th>
              <th>
                Valor
              </th>
              <th>
                Estado general
              </th>
              <th>
                Compartido
              </th>
              <th>
                Opciones
              </th>
            </tr>
            </thead>

          <tbody>
            @include('content.cases.partials.ajax.case_bill')
          </tbody>
          </table>
    </div>
  </div>

    
  