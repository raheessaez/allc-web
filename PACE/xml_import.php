<?php

$xml = simplexml_load_file("prueba.xml");

echo 'OperatorID: '.$xml->OperatorID.'<br>';
echo 'WorkstationID: '.$xml->WorkstationID.'<br>';
echo 'RetailStoreID: '.$xml->RetailStoreID.'<br>';
echo 'BusinessDayDate: '.$xml->BusinessDayDate.'<br>';
echo 'SequenceNumber: '.$xml->SequenceNumber.'<br>';
echo 'BeginDateTime: '.$xml->BeginDateTime.'<br>';
echo 'EndDateTime: '.$xml->EndDateTime.'<br>';
echo 'RetailTransaction '.$xml->RetailTransaction.'<br>';
echo '  RingElapsedTime: '.$xml->RetailTransaction->RingElapsedTime.'<br>';
echo '  TenderElapsedTime: '.$xml->RetailTransaction->TenderElapsedTime.'<br>';
echo '  TenderElapsedTime: '.$xml->RetailTransaction->TenderElapsedTime.'<br>';
echo '  TenderElapsedTime: '.$xml->RetailTransaction->TenderElapsedTime.'<br>';
echo '  TenderElapsedTime: '.$xml->RetailTransaction->TenderElapsedTime.'<br>';
echo '  TenderElapsedTime: '.$xml->RetailTransaction->TenderElapsedTime.'<br>';
echo '  TenderElapsedTime: '.$xml->RetailTransaction->TenderElapsedTime.'<br>';
echo '  TenderElapsedTime: '.$xml->RetailTransaction->TenderElapsedTime.'<br>';