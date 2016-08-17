<?php

$FILE = $_POST['FILE'];


$xml= simplexml_load_file("xml/".$FILE);
echo "Transaction".'<br>';
echo "OperatorID =".$xml->OperatorID.'<br>';  
echo "WorkstationID =".$xml->WorkstationID.'<br>';  
echo "RetailStoreID =".$xml->RetailStoreID.'<br>';  
echo "BusinessDayDate =".$xml->BusinessDayDate.'<br>';  
echo "SequenceNumber =".$xml->SequenceNumber.'<br>';  
echo "BeginDateTime =".$xml->BeginDateTime.'<br>';  
echo "EndDateTime =".$xml->EndDateTime.'<br><br>'; 

echo "RetailTransaction".'<br>';
echo "RingElapsedTime=".$xml->RetailTransaction->RingElapsedTime.'<br>'; 
echo "TenderElapsedTime=".$xml->RetailTransaction->TenderElapsedTime.'<br>'; 
echo "IdleElapsedTime=".$xml->RetailTransaction->IdleElapsedTime.'<br>'; 
echo "ItemCount=".$xml->RetailTransaction->ItemCount.'<br>';
echo "LineItemsScannedCount=".$xml->RetailTransaction->LineItemsScannedCount.'<br>';
echo "lineItemsScannedPercent=".$xml->RetailTransaction->lineItemsScannedPercent.'<br>';
echo "LineItemsKeyedCount=".$xml->RetailTransaction->LineItemsKeyedCount.'<br>'; 
echo "lineItemsKeyedPercent=".$xml->RetailTransaction->lineItemsKeyedPercent.'<br>'; 
echo "keyDepartmentCount=".$xml->RetailTransaction->keyDepartmentCount.'<br>'; 
echo "keyDepartmentPercent=".$xml->RetailTransaction->keyDepartmentPercent.'<br>';
echo "IncludeTax=".$xml->RetailTransaction->IncludeTax.'<br><br>';

echo "LineItem".'<br>';

		
echo "LineItem voidFlag=" .$xml->RetailTransaction->LineItem['VoidFlag']."<br>";
echo "SequenceNumber=".$xml->RetailTransaction->LineItem->SequenceNumber.'<br><br>';
 
echo "Sale".'<br>';

echo "ItemCode sale=".$xml->RetailTransaction->LineItem->Sale->ItemCode.'<br>'; 
echo "ItemType sale=".$xml->RetailTransaction->LineItem->Sale->ItemType.'<br>'; 
echo "Quantity sale=".$xml->RetailTransaction->LineItem->Sale->Quantity.'<br>'; 
echo "units sale=".$xml->RetailTransaction->LineItem->Sale->units.'<br>'; 
echo "RegularSalesUnitPrice sale=".$xml->RetailTransaction->LineItem->Sale->RegularSalesUnitPrice.'<br>'; 
echo "ActualSalesUnitPrice sale=".$xml->RetailTransaction->LineItem->Sale->ActualSalesUnitPrice.'<br>'; 
echo "ExtendedAmount sale=".$xml->RetailTransaction->LineItem->Sale->ExtendedAmount.'<br>'; 
echo "unitDiscountAmount sale=".$xml->RetailTransaction->LineItem->Sale->unitDiscountAmount.'<br>'; 
echo "extendedDiscountAmount sale=".$xml->RetailTransaction->LineItem->Sale->extendedDiscountAmount.'<br>'; 
echo "EntryMethodCode sale=".$xml->RetailTransaction->LineItem->Sale->EntryMethodCode.'<br>'; 
echo "TaxType sale=".$xml->RetailTransaction->LineItem->Sale->TaxType.'<br>'; 
echo "POSDepartment sale=".$xml->RetailTransaction->LineItem->Sale->POSDepartment.'<br>'; 
echo "MerchandiseHierarchyGroup sale=".$xml->RetailTransaction->LineItem->Sale->MerchandiseHierarchyGroup.'<br>'; 
echo "PriceEntered sale=".$xml->RetailTransaction->LineItem->Sale->PriceEntered.'<br>'; 
echo "appliedTax sale=".$xml->RetailTransaction->LineItem->Sale->appliedTax.'<br><br>'; 


echo "LineItem".'<br>';
echo "LineItem voidFlag=" .$xml->RetailTransaction->LineItem[1]['VoidFlag']."<br>";
echo "SequenceNumber=".$xml->RetailTransaction->LineItem[1]->SequenceNumber.'<br><br>';

echo "Tender".'<br>'; 
echo "TenderAccountNumber=" .$xml->RetailTransaction->LineItem[1]->Tender['TenderType']."<br>";
echo "ForeignCurrencyAmount=" .$xml->RetailTransaction->LineItem[1]->Tender->ForeignCurrencyAmount."<br>";
echo "Amount=" .$xml->RetailTransaction->LineItem[1]->Tender->Amount."<br>";
echo "FeeAmount=" .$xml->RetailTransaction->LineItem[1]->Tender->FeeAmount."<br>";
echo "Status=" .$xml->RetailTransaction->LineItem[1]->Tender->Status."<br>";
echo "ExchangeRate=" .$xml->RetailTransaction->LineItem[1]->Tender->ExchangeRate."<br>";
echo "amountAppliedToTransaction=" .$xml->RetailTransaction->LineItem[1]->Tender->amountAppliedToTransaction."<br><br>";              


echo "LineItem".'<br>';
echo "LineItem TypeCode=" .$xml->RetailTransaction->LineItem[2]['TypeCode']."<br>";
echo "SequenceNumber=".$xml->RetailTransaction->LineItem[2]->SequenceNumber.'<br><br>';

echo "Tax=".$xml->RetailTransaction->LineItem[2]->Tax['TaxType'].'<br>';
echo "taxablePercent=".$xml->RetailTransaction->LineItem[2]->Tax->taxablePercent.'<br>';
echo "TaxableAmount=".$xml->RetailTransaction->LineItem[2]->Tax->TaxableAmount.'<br>';
echo "Amount=".$xml->RetailTransaction->LineItem[2]->Tax->Amount.'<br>';
echo "taxPercent=".$xml->RetailTransaction->LineItem[2]->Tax->taxPercent.'<br><br>';

echo "Totals".'<br>';
foreach ($xml->RetailTransaction->Totals->Total as $Total) 	{
	$atributos = $Total->attributes();
	echo "Totals=" .$atributos['TotalType']. ",   CancelFlag= " .$atributos['CancelFlag']. "<br>";
	echo "Amount=" .$Total->Amount."<br>";
	}
	
	echo '<br>'."PreferredCustomerData".'<br>';
	echo "CustomerAccountID=".$xml->RetailTransaction->PreferredCustomerData->CustomerAccountID.'<br>';
	echo "Points=".$xml->RetailTransaction->PreferredCustomerData->Points.'<br>';
	echo "CouponAmount=".$xml->RetailTransaction->PreferredCustomerData->CouponAmount.'<br>';
	echo "CouponCount=".$xml->RetailTransaction->PreferredCustomerData->CouponCount.'<br>';
	echo "MessageCount=".$xml->RetailTransaction->PreferredCustomerData->MessageCount.'<br>';
	echo "tranferredTransAmount=".$xml->RetailTransaction->PreferredCustomerData->tranferredTransAmount.'<br>';
	echo "TransferredTransCount=".$xml->RetailTransaction->PreferredCustomerData->TransferredTransCount.'<br>';
	echo "BonusPoints=".$xml->RetailTransaction->PreferredCustomerData->BonusPoints.'<br>';
	echo "RedeemedPoints=".$xml->RetailTransaction->PreferredCustomerData->RedeemedPoints.'<br>';
	echo "EntryMethod=".$xml->RetailTransaction->PreferredCustomerData->EntryMethod.'<br>';
	
	echo '<br>'."FacturaElec".'<br>';
 echo "Fecha=".$xml->RetailTransaction->FacturaElec->Fecha.'<br>';
 echo "Hora=".$xml->RetailTransaction->FacturaElec->Hora.'<br>';
	echo "NumeroDoc=".$xml->RetailTransaction->FacturaElec->NumeroDoc.'<br>';
	echo "TipoDoc=".$xml->RetailTransaction->FacturaElec->TipoDoc.'<br>';
	echo "Estado=".$xml->RetailTransaction->FacturaElec->Estado.'<br>';
	echo "NumeroFac=".$xml->RetailTransaction->FacturaElec->NumeroFac.'<br>';
	
	

 echo '<br>'."StringUsuariosDataList".'<br>';
  foreach ($xml->RetailTransaction->StringUsuariosDataList->StringUsuario as $Total) 	{
	  
	   echo "SequenceNumber=" .$Total->SequenceNumber."<br>";
				echo "Cadena=" .$Total->Cadena."<br><br>";
	}


?>



