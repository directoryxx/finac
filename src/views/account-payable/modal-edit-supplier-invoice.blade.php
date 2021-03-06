<div class="modal fade" id="modal_edit_supplier_invoice" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModalSupplierInvoice">Supplier Invoice - Amount to Pay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="SupplierInvoiceForm">
									<input type="hidden" name="si_uuid" value="" disabled>
                  <div class="m-portlet__body">
                      <div class="form-group m-form__group row ">
                          <div class="col-sm-6 col-md-6 col-lg-6">
                              <label class="form-control-label">
                                  Date
                              </label>

                              @component('label::data-info')
                                  @slot('text', 'generated')
                              @endcomponent
                          </div>
                          <div class="col-sm-6 col-md-6 col-lg-6">
                              <label class="form-control-label">
                                  Transaction No.
                              </label>

                              @component('label::data-info')
                                  @slot('text', 'generated')
                              @endcomponent
                          </div>
                      </div>
                      <div class="form-group m-form__group row ">
                          <div class="col-sm-6 col-md-6 col-lg-6">
                              <label class="form-control-label">
                                  Account Code
                              </label>

                              @component('label::data-info')
                                  @slot('text', 'generated')
                              @endcomponent
                          </div>
                          <div class="col-sm-6 col-md-6 col-lg-6">
                              <div class="form-group m-form__group row ">
                                  <div class="col-sm-6 col-md-6 col-lg-6">
                                      <label class="form-control-label">
                                          Currency
                                      </label>

                                      @component('label::data-info')
                                          @slot('text', 'generated')
                                      @endcomponent
                                  </div>
                                  <div class="col-sm-6 col-md-6 col-lg-6">
                                      <label class="form-control-label">
                                          Exchange Rate
                                      </label>

                                      @component('label::data-info')
                                          @slot('text', 'generated')
                                      @endcomponent
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group m-form__group row ">
                          <div class="col-sm-6 col-md-6 col-lg-6">
                              <label class="form-control-label">
                                  Total Amount
                              </label>

                              @component('label::data-info')
                                  @slot('text', 'generated')
                              @endcomponent
                          </div>
                          <div class="col-sm-6 col-md-6 col-lg-6">
                              <label class="form-control-label">
                                  Paid Amount
                              </label>

                              @component('label::data-info')
                                  @slot('text', 'generated')
                              @endcomponent
                          </div>
                      </div>
                      <div class="form-group m-form__group row ">
                          <div class="col-sm-6 col-md-6 col-lg-6">
                              <label class="form-control-label">
                                  Amount to Pay
                              </label>

                              @component('input::number')
                                  @slot('id', 'amount_to_pay')
                                  @slot('text', 'amount_to_pay')
                                  @slot('name', 'debit')
                              @endcomponent
                          </div>
                          <div class="col-sm-6 col-md-6 col-lg-6">
                              <label class="form-control-label">
                                  Exchange Rate Gap
                              </label>

                              @component('label::data-info')
                                  @slot('text', 'generated')
                              @endcomponent
                          </div>
                      </div>
                      <div class="form-group m-form__group row ">
                          <div class="col-sm-12 col-md-12 col-lg-12">
                              <label class="form-control-label">
                                  Description
                              </label>

                              @component('input::textarea')
                                  @slot('id', 'description')
                                  @slot('text', 'description')
                                  @slot('name', 'description')
                                  @slot('rows','5')
                              @endcomponent
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <div class="flex">
                          <div class="action-buttons">
                              <div class="flex">
                                  <div class="action-buttons">
                                      @component('buttons::submit')
                                          @slot('id', 'update_supplier_invoice')
                                          @slot('type', 'button')
                                      @endcomponent

                                      @include('buttons::reset')

                                      @include('buttons::close')
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
