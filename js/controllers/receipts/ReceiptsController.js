$(function(){

  appScope.loadReceipts = function(){
	  appScope.loadData('receipts', '/receipts/dynload/'+appScope.washId);
	};

  appScope.loadExpences = function(){
    appScope.loadData('expences', '/expences/dynload/'+appScope.washId);
  };

  appScope.loadCashbox = function(){
    appScope.loadData('receipts', '/receipts/dynload/'+appScope.washId);
    appScope.loadData('expences', '/expences/dynload/'+appScope.washId);
  }

  appScope.totalReceiptsSumm = function()
  {
    var result = 0;
    if(appScope.receipts){
      for(var i = 0; i< appScope.receipts.length; i++){
        result += appScope.receipts[i].amount;
      }
    }

    return result;
  }

  appScope.totalExpencesSumm = function(){
    var result = 0;
    if(appScope.expences){
      for(var i = 0; i< appScope.expences.length; i++){
        result += appScope.expences[i].amount;
      }
    }

    return result;
  }

  appScope.totalCashSumm = function()
  {
    var result = 0;
    var receiptsSumm = 0
    if(appScope.receipts){
      for(var i = 0; i< appScope.receipts.length; i++){
        receiptsSumm += appScope.receipts[i].amount;
      }
    }

    var expencesSumm = 0
    if(appScope.expences){
      for(var i = 0; i< appScope.expences.length; i++){
        expencesSumm += appScope.expences[i].amount;
      }
    }


    return receiptsSumm - expencesSumm;
  }

});
