/**
 * Sample code to show a parameter dialog with ExtJS
 *
 * $Id$
 */
Ext.onReady(function(){
	var win;
	var button = Ext.get('params-btn');
	
	button.on('click', function(){
		var paramsItem = 'data[sys_dmail_group][1][tx_directmailuserfunc_params]_hr';
		var params = document.editform[paramsItem].value;

		Ext.Msg.prompt(
			"Parameters for myRecipientList",
			"How many items do you want in your list?",
			function(btn, text) {
				if (btn == 'ok'){
					updateParameters(text);
				}
			},
			this, false, params
		);
	});
});    			