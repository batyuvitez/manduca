var navDialogEl = document.querySelector('.dialog');
var dialogOverlay = document.querySelector('.dialog-overlay');

var myDialog = new Dialog(navDialogEl, dialogOverlay);
myDialog.addEventListeners('.open-dialog', '.close-dialog');