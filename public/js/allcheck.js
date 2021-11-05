/**
 * @web: quiz
 * @author: Ly
 * @date: 2017/07/17
 */

function toggle(source) {
	checkboxes = document.getElementsByName('ckb');
	for(var i = 0, n = checkboxes.length; i < n; i++) {
		checkboxes[i].checked = source.checked;
	}
}
