var dotalegendGet = {
	
	getAllHeroes:function(_callBack){
		$.get('http://localhost/dotalegend/phps2/getAllHeroes.php',function(_data,_result){

			if(typeof _data == 'object'){

				_callBack.call({},_data,_result);
			}else{
				_data = JSON.parse(_data);
				_callBack.call({},_data,_result);
			}
		});
	},
	getHero:function(_sendData,_callBack){
		$.get('http://localhost/dotalegend/phps2/getHero.php?heroNamesJson='+_sendData,function(_data,_result){

			if(typeof _data == 'object'){

				_callBack.call({},_data,_result);
			}else{
				_data = JSON.parse(_data);
				_callBack.call({},_data,_result);
			}
		});
	}
};