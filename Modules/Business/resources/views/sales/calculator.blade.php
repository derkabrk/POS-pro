<div class="modal fade" id="calculatorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog calculator-dialog" role="document">
        <div class="modal-content calculator-content">
            <div class="modal-header d-flex align-items-center justify-content-between">
                <div class="custom-modal-header">
                    <button type="button" class="btn-close custom-close-btn calculator-btn" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body">
                <div class="container calculator">
                    <form>
                        <input readonly id="display" type="text" class="form-control-lg text-right w-100" value="" />
                    </form>

                    <div class="d-flex justify-content-between button-row">
                        <button id="left-parenthesis" type="button" class="operator-group calculator-btn">
                            &#40;
                        </button>
                        <button id="right-parenthesis" type="button" class="operator-group calculator-btn">
                            &#41;
                        </button>
                        <button id="square-root" type="button" class="operator-group calculator-btn">
                            &#8730;
                        </button>
                        <button id="square" type="button" class="operator-group calculator-btn">
                            &#120;&#178;
                        </button>
                    </div>

                    <div class="d-flex justify-content-between button-row">
                        <button id="clear" type="button" class="calculator-btn">&#67;</button>
                        <button id="backspace" type="button" class="calculator-btn">&#9003;</button>
                        <button id="ans" type="button" class="operand-group calculator-btn">
                            &#65;&#110;&#115;
                        </button>
                        <button id="divide" type="button" class="operator-group calculator-btn">
                            &#247;
                        </button>
                    </div>

                    <div class="d-flex justify-content-between button-row">
                        <button id="seven" type="button" class="operand-group calculator-btn">&#55;</button>
                        <button id="eight" type="button" class="operand-group calculator-btn">&#56;</button>
                        <button id="nine" type="button" class="operand-group calculator-btn">&#57;</button>
                        <button id="multiply" type="button" class="operator-group calculator-btn">
                            &#215;
                        </button>
                    </div>

                    <div class="d-flex justify-content-between button-row">
                        <button id="four" type="button" class="operand-group calculator-btn">&#52;</button>
                        <button id="five" type="button" class="operand-group calculator-btn">&#53;</button>
                        <button id="six" type="button" class="operand-group calculator-btn">&#54;</button>
                        <button id="subtract" type="button" class="operator-group calculator-btn">
                            &#8722;
                        </button>
                    </div>

                    <div class="d-flex justify-content-between button-row">
                        <button id="one" type="button" class="operand-group calculator-btn">&#49;</button>
                        <button id="two" type="button" class="operand-group calculator-btn">&#50;</button>
                        <button id="three" type="button" class="operand-group calculator-btn">&#51;</button>
                        <button id="add" type="button" class="operator-group calculator-btn">&#43;</button>
                    </div>

                    <div class="d-flex justify-content-between button-row">
                        <button id="percentage" type="button" class="operand-group calculator-btn">
                            &#37;
                        </button>
                        <button id="zero" type="button" class="operand-group calculator-btn">&#48;</button>
                        <button id="decimal" type="button" class="operand-group calculator-btn">&#46;</button>
                        <button id="equal" type="button" class="calculator-btn">&#61;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
