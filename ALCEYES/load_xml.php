<?php include("headerhtml.inc"); ?>

<table style="width:100%"  id="Listado">
    <tr>
        <th>Nodo</th>
        <th>Nombre</th>
        <th>Valor</th>

    </tr>

    <?php
    $FILE = $_GET['FILE'];
    $ESTADO = $_GET['ESTADO'];

    if (strcmp($ESTADO, 'P') === 0) {

        $xml = simplexml_load_file("../../../ARTS/TSLRecords/processedTlog/" . $FILE);
    }
    if (strcmp($ESTADO, 'E') === 0) {

        $xml = simplexml_load_file("../../../ARTS/TSLRecords/errorTlogs/" . $FILE);
    }
    if (strcmp($ESTADO, 'D') === 0) {

        $xml = simplexml_load_file("../../../ARTS/TSLRecords/duplicatedTlog/" . $FILE);
    }


    echo "" . $ItemCode;
    ?>
    <tr>
        <td><strong>Transaction</strong></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>OperatorID </td>
        <td><?php echo $xml->OperatorID; ?> </td>
    </tr>
    <tr>
        <td></td>
        <td>WorkstationID </td>
        <td><?php echo $xml->WorkstationID; ?> </td>
    </tr>
    <tr>
        <td></td>
        <td>RetailStoreID </td>
        <td><?php echo $xml->RetailStoreID; ?> </td>
    </tr>
    <tr>
        <td></td>
        <td>BusinessDayDate </td>
        <td><?php echo $xml->BusinessDayDate; ?> </td>
    </tr>
    <tr>
        <td></td>
        <td>SequenceNumber </td>
        <td><?php echo $xml->SequenceNumber; ?> </td>
    </tr>
    <tr>
        <td></td>
        <td>BeginDateTime </td>
        <td><?php echo $xml->BeginDateTime; ?> </td>
    </tr>
    <tr>
        <td></td>
        <td>EndDateTime </td>
        <td><?php echo $xml->EndDateTime; ?> </td>
    </tr>


<?php
foreach ($xml->TenderControlTransaction as $TenCon) {
    $atributos = $TenCon->attributes();

    if (strlen($atributos['TenderControlTypeCode']) > 0) {
        ?>
            <tr>
                <td><strong>TenderControlTransaction</strong></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td> 
                <td>TotalType</td>
                <td><?php echo $atributos['TenderControlTypeCode']; ?> </td>
            </tr>


        <?php
    }
    
    foreach ($TenCon as $Pickup) {
        $operacode = $Pickup->OperatorCode;
        if (strlen($operacode) > 0) {
            ?>
                <tr>
                    <td><strong>TenderPickup</strong></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td> 
                    <td>Outbound</td>
                    <td><?php echo $Pickup->Outbound; ?> </td>
                </tr>
                <tr>
                    <td></td> 
                    <td>Inbound</td>
                    <td><?php echo $Pickup->Inbound; ?> </td>
                </tr>
                <tr>
                    <td></td> 
                    <td>OperatorCode</td>
                    <td><?php echo $Pickup->OperatorCode; ?> </td>
                </tr>

            <?php
        }
        foreach ($TenCon as $ValeEmpleado) {
            $ced = $ValeEmpleado->Cedula;
            if (strlen($ced) > 0) {
                ?>
                    <tr>
                        <td><strong>ValeEmpleado</strong></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td> 
                        <td>Cedula</td>
                        <td><?php echo $ValeEmpleado->Cedula; ?> </td>
                    </tr>
                    <tr>
                        <td></td> 
                        <td>CodSociedadSAP</td>
                        <td><?php echo $ValeEmpleado->CodSociedadSAP; ?> </td>
                    </tr>
                    <tr>
                        <td></td> 
                        <td>Comprobante</td>
                        <td><?php echo $ValeEmpleado->Comprobante; ?> </td>
                    </tr>

                    <tr>
                        <td></td> 
                        <td>Codigo</td>
                        <td><?php echo $ValeEmpleado->Codigo; ?> </td>
                    </tr>
                    <tr>
                        <td></td> 
                        <td>Cuotas</td>
                        <td><?php echo $ValeEmpleado->Cuotas; ?> </td>
                    </tr>
                    <tr>
                        <td></td> 
                        <td>Valor</td>
                        <td><?php echo $ValeEmpleado->Valor; ?> </td>
                    </tr>

                <?php
            }
        }
        foreach ($TenCon as $TenderControlTransactionTenderLineItem) {
            $secNumber = $TenderControlTransactionTenderLineItem->SequenceNumber;
            if (strlen($secNumber) > 0) {
                ?>
                    <tr>
                        <td><strong>TenderControlTransactionTenderLineItem</strong></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td> 
                        <td>SequenceNumber</td>
                        <td><?php echo $TenderControlTransactionTenderLineItem->SequenceNumber; ?> </td>
                    </tr>
                    <tr>
                        <td></td> 
                        <td>TenderTypeCode</td>
                        <td><?php echo $TenderControlTransactionTenderLineItem->TenderTypeCode; ?> </td>
                    </tr>
                    <tr>
                        <td></td> 
                        <td>exchangeRate</td>
                        <td><?php echo $TenderControlTransactionTenderLineItem->exchangeRate; ?> </td>
                    </tr>

                    <tr>
                        <td></td> 
                        <td>Amount</td>
                        <td><?php echo $TenderControlTransactionTenderLineItem->Amount; ?> </td>
                    </tr>
                    <tr>
                        <td></td> 
                        <td>foreignCurrencyAmount</td>
                        <td><?php echo $TenderControlTransactionTenderLineItem->foreignCurrencyAmount; ?> </td>
                    </tr>
                    <tr>
                        <td></td> 
                        <td>Count</td>
                        <td><?php echo $TenderControlTransactionTenderLineItem->Count; ?> </td>
                    </tr>

                <?php
            }
        }
    }
}
?>



    <?php
    foreach ($xml->ControlTransaction as $control) {
        ?>

        <?php
        foreach ($control->SignOff as $SignOff) {
            $conTran = $SignOff->quantityOfTransactions;

            if (strlen($conTran) > 0) {
                ?>

                <tr>
                    <td><strong>ControlTransaction</strong></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><strong>SignOff</strong></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td>quantityOfTransactions </td>
                    <td><?php echo $SignOff->quantityOfTransactions; ?> </td>
                </tr>

            <?php
        }
    }
}
?>

<?php
foreach ($xml->RetailTransaction as $retail) {
    $ring = $retail->RingElapsedTime;
    if (strlen($ring) > 0) {
        # code...
        ?>
            <tr>
                <td><strong>RetailTransaction</strong></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>RingElapsedTime </td>
                <td><?php echo $retail->RingElapsedTime; ?> </td>
            </tr>
            <tr>
                <td></td>
                <td>TenderElapsedTime </td>
                <td><?php echo $retail->TenderElapsedTime; ?> </td>
            </tr>
            <tr>
                <td></td>
                <td>IdleElapsedTime </td>
                <td><?php echo $retail->IdleElapsedTime; ?> </td>
            </tr>
            <tr>
                <td></td>
                <td>ItemCount </td>
                <td><?php echo $retail->ItemCount; ?> </td>
            </tr>
            <tr>
                <td></td>
                <td>LineItemsScannedCount </td>
                <td><?php echo $retail->LineItemsScannedCount; ?> </td>
            </tr>
            <tr>
                <td></td>
                <td>lineItemsScannedPercent </td>
                <td><?php echo $retail->lineItemsScannedPercent; ?> </td>
            </tr>
            <tr>
                <td></td>
                <td>LineItemsKeyedCount </td>
                <td><?php $retail->LineItemsKeyedCount; ?> </td>
            </tr>
            <tr>
                <td></td>
                <td>lineItemsKeyedPercent </td>
                <td><?php echo $retail->lineItemsKeyedPercent; ?> </td>
            </tr>
            <tr>
                <td></td>
                <td>keyDepartmentCount </td>
                <td><?php echo $retail->keyDepartmentCount; ?> </td>
            </tr>
            <tr>
                <td></td>
                <td>keyDepartmentPercent </td>
                <td><?php echo $retail->keyDepartmentPercent; ?> </td>
            </tr>
            <tr>
                <td></td>
                <td>IncludeTax </td>
                <td><?php echo $retail->IncludeTax; ?> </td>
            </tr> 



        <?php
    }
}
//print_r($xml);
if (is_array($xml->RetailTransaction->LineItem) || is_object($xml->RetailTransaction->LineItem)) {
    foreach ($xml->RetailTransaction->LineItem as $Total) {
        $atributos = $Total->attributes();
        $ItemCode = $Total->Sale->ItemCode;
        ?>  
            <tr>
                <td><strong>LineItem</strong></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td></td> 
                <td>TotalType</td>
                <td><?php echo $atributos['VoidFlag']; ?> </td>
            </tr>

            <tr>
                <td></td>
                <td> SequenceNumber </td>
                <td><?php echo $Total->SequenceNumber; ?> </td>
            </tr> 





        <?php
        if (strlen($ItemCode) > 0) {
            ?>

                <tr>
                    <td><strong>Sale</strong></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                <tr>
                    <td></td>
                    <td>sequenceNumber </td>
                    <td><?php echo $Total->Sale->sequenceNumber; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>ItemCode sale </td>
                    <td><?php echo $Total->Sale->ItemCode; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>ItemType sale </td>
                    <td><?php echo $Total->Sale->ItemType; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>Quantity sale </td>
                    <td><?php echo $Total->Sale->Quantity; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>units sale </td>
                    <td><?php echo $Total->Sale->units; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>RegularSalesUnitPrice sale </td>
                    <td><?php echo $Total->Sale->RegularSalesUnitPrice; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>ActualSalesUnitPrice sale </td>
                    <td><?php echo $Total->Sale->ActualSalesUnitPrice; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>ExtendedAmount sale </td>
                    <td><?php echo $Total->Sale->ExtendedAmount; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>unitDiscountAmount sale </td>
                    <td><?php echo $Total->Sale->unitDiscountAmount; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>extendedDiscountAmount sale </td>
                    <td><?php echo $Total->Sale->extendedDiscountAmount; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>EntryMethodCode sale </td>
                    <td><?php echo $Total->Sale->EntryMethodCode; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>TaxType sale </td>
                    <td><?php echo $Total->Sale->TaxType; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>POSDepartment sale </td>
                    <td><?php echo $Total->Sale->POSDepartment; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>MerchandiseHierarchyGroup sale </td>
                    <td><?php echo $Total->Sale->MerchandiseHierarchyGroup; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>PriceEntered sale </td>
                    <td><?php echo $Total->Sale->PriceEntered; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>appliedTax sale </td>
                    <td><?php echo $Total->Sale->appliedTax; ?> </td>
                </tr>


            <?php
        }
    }
    ?>

    <?php
    foreach ($Total->Tender as $key) {
        $attr = $key->attributes();
        $amount = $key->Amount;
        //echo "<tr><td>".print_r($key)."</td></tr>";
        //echo "<tr><td>".$key->Amount."</td></tr>";

        if (strlen($amount) > 0) {
            ?>

                <tr>
                    <td><strong>Tender</strong></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>TenderType </td>
                    <td><?php echo $attr['TenderType']; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>TenderAccountNumber</td>
                    <td><?php echo $key->TenderAccountNumber; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>ForeignCurrencyAmount </td>
                    <td><?php echo $key->ForeignCurrencyAmount; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>Amount </td>
                    <td><?php echo $key->Amount; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>FeeAmount </td>
                    <td><?php echo $key->FeeAmount; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>Status </td>
                    <td><?php echo $key->Status; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>ExchangeRate </td>
                    <td><?php echo $key->ExchangeRate; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>amountAppliedToTransaction </td>
                    <td><?php echo $key->amountAppliedToTransaction; ?> </td>
                </tr> 



            <?php
        }
        ?>


        <?php
    }
    ?>





    <?php
}
if (is_array($Total->Tax) || is_object($Total->Tax)) {
    foreach ($Total->Tax as $tax) {
        $attr = $tax->attributes();
        $taxable = $tax->taxablePercent;
        //echo "<tr><td>".print_r($key)."</td></tr>";
        //echo "<tr><td>".$key->Amount."</td></tr>";
        if (strlen($taxable) > 0) {
            ?>

                <tr>
                    <td><strong>Tax</strong></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Tax</td>
                    <td><?php echo $attr['TaxType']; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>taxablePercent</td>
                    <td><?php echo $tax->taxablePercent; ?> </td>
                </tr>  
                <tr>
                    <td></td>
                    <td>TaxableAmount</td>
                    <td><?php echo $tax->TaxableAmount; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>Amount</td>
                    <td><?php echo $tax->Amount; ?> </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>taxPercent</td>
                    <td><?php echo $tax->taxPercent; ?> </td>
                </tr> 







            <?php
        }
    }
}
?>

<?php
if (is_array($Total->Tax) || is_object($Total->Tax)) {
    foreach ($xml->RetailTransaction->ManagerOverrides as $manager) {

        foreach ($manager->ManagerOverride as $man) {
            $numero = $man->Number;
            if (strlen($numero) > 0) {
                ?>

                    <tr>
                        <td><strong>ManagerOverride</strong></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>SequenceNumber</td>
                        <td><?php echo $man->SequenceNumber; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Number</td>
                        <td><?php echo $man->Number; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Reason</td>
                        <td><?php echo $man->Reason; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Index</td>
                        <td><?php echo $man->Index; ?></td>
                    </tr>

                    <?php
                }
            }
        }
    }
    ?>











<?php
foreach ($xml->RetailTransaction->Totals->Total as $Total) {
    $atributos = $Total->attributes();
    ?>   
        <tr>

            <td><strong>Totals</strong></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td> 
            <td>TotalType</td>
            <td><?php echo $atributos['TotalType']; ?> </td>
        </tr>
        <tr>
            <td></td>
            <td>CancelFlag</td>
            <td><?php echo $atributos['CancelFlag']; ?> </td>
        </tr>

        <tr>
            <td></td>
            <td>Amount</td>
            <td><?php echo $Total->Amount; ?></td>
        </tr>



<?php } ?>


    <?php
    foreach ($xml->RetailTransaction->PreferredCustomerData as $preferred) {
        $point = $preferred->Points;

        if (strlen($point) > 0) {
            ?>  


            <tr>
                <td><strong>PreferredCustomerData</strong></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>CustomerAccountID</td>
                <td><?php echo $preferred->CustomerAccountID; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Points</td>
                <td><?php echo $preferred->Points; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>CouponAmount</td>
                <td><?php echo $preferred->CouponAmount; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>CouponCount</td>
                <td><?php echo $preferred->CouponCount; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>MessageCount</td>
                <td><?php echo $preferred->MessageCount; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>tranferredTransAmount</td>
                <td><?php echo $preferred->tranferredTransAmount; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>TransferredTransCount</td>
                <td><?php echo $preferred->TransferredTransCount; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>BonusPoints</td>
                <td><?php echo $preferred->BonusPoints; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>RedeemedPoints</td>
                <td><?php echo $preferred->RedeemedPoints; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>EntryMethod</td>
                <td><?php echo $preferred->EntryMethod; ?></td>
            </tr>
        <?php
    }
}
?>


<?php
foreach ($xml->RetailTransaction->FacturaElec as $factura) {
    $fecha = $factura->Fecha;
    if (strlen($fecha) > 0) {
        ?> 
            <tr>
                <td><strong>FacturaElec</strong></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Fecha</td>
                <td><?php echo $factura->Fecha; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Hora</td>
                <td><?php echo $factura->Hora; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>NumeroDoc</td>
                <td><?php echo $factura->NumeroDoc; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>TipoDoc</td>
                <td><?php echo $factura->TipoDoc; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Estado</td>
                <td><?php echo $factura->Estado; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>NumeroFac</td>
                <td><?php echo $factura->NumeroFac; ?></td>
            </tr>




        <?php
    }
}
?> 


<?php
foreach ($xml->RetailTransaction->InvoiceData as $ino) {
    $cusid = $ino->CustomerID;
    if (strlen($cusid) > 0) {
        ?> 
            <tr>
                <td><strong>InvoiceData</strong></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>CustomerID</td>
                <td><?php echo $ino->CustomerID; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>customerType</td>
                <td><?php echo $ino->customerType; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>CustomerName</td>
                <td><?php echo $ino->CustomerName; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Address</td>
                <td><?php echo $ino->Address; ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Telephone</td>
                <td><?php echo $ino->Telephone; ?></td>
            </tr>

            <?php
        }
    }
    ?>


<?php

foreach ($xml->TenderControlTransaction->RetencionData as $ret) {
    foreach ($ret->RetencionData as $Retencion) {
        $Secnum = $Retencion->SequenceNumber;
        if (strlen($Secnum) > 0) {
            ?>

                <tr>
                    <td><strong>RetencionData</strong></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>SequenceNumber</td>
                    <td><?php echo $Retencion->SequenceNumber; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Indicador</td>
                    <td><?php echo $Retencion->Indicador; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Terminal</td>
                    <td><?php echo $Retencion->Terminal; ?></td>
                </tr>

                <tr>
                    <td></td>
                    <td>Voucher</td>
                    <td><?php echo $Retencion->Voucher; ?></td>
                </tr>

                <tr>
                    <td></td>
                    <td>NumeroSRI</td>
                    <td><?php echo $Retencion->NumeroSRI; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Monto</td>
                    <td><?php echo $Retencion->Monto; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>BaseImp</td>
                    <td><?php echo $Retencion->BaseImp; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Porcentaje</td>
                    <td><?php echo $Retencion->Porcentaje; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>IdCliente</td>
                    <td><?php echo $Retencion->IdCliente; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Nombre</td>
                    <td><?php echo $Retencion->Nombre; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Tipo</td>
                    <td><?php echo $Retencion->Tipo; ?></td>
                </tr>

            <?php
        }
    }
}
?> 





<?php
foreach ($xml->RetailTransaction->StringUsuariosDataList->StringUsuario as $Total) {
    $atributos = $Total->attributes();
    $number = $Total->SequenceNumber;
    if (strlen($number) > 0) {
        ?>  
            <tr>
                <td><strong>StringUsuariosDataList</strong></td>
                <td></td>
                <td></td>	
            </tr>
            <tr>
                <td></td>	
                <td>SequenceNumber</td>
                <td><?php echo $Total->SequenceNumber; ?> </td>
            </tr>
            <tr>
                <td></td>
                <td>Cadena</td>
                <td><?php echo $Total->Cadena; ?> </td>
            </tr>





        <?php }
    }
    ?>



</table>



