var address = "http://localhost:3000";
var currentPlayer = 0;
var grid = [[-1,-1,-1], [-1,-1,-1], [-1,-1,-1]];
var gameover = false;

$(document).ready(function() {
	// Reset lights
	updateLights();

	$('.button-group button').click(function() {
		if (!gameover) {
			var button = $(this).attr('id');
			var x = button[5];
			var y = button[4];

			// Update the cell
			if (grid[y][x] == -1) {
				grid[y][x] = currentPlayer;

				// Update the cell
				updateCell(x, y);
				updateLight(x, y);
				
				// Check winner
				if (checkWinner()) {
					//alert('We have a winner!');
				} else if (isGameboardFull()) {
					//alert('The gameboard is full. No winner :-(.');
				} else {
					// Switch player
					currentPlayer = (currentPlayer + 1) % 2;
				}
			} else {
				alert('This field has already been assigned to a player!');
			}	
		} else {
			alert('Game over');
		}	
	});
});

function updateCell(x, y) {
	if (grid[y][x] == 0) {
		$('#cell' + y + x).addClass('player1');
	} else if (grid[y][x]) {
		$('#cell' + y + x).addClass('player2');
	}
}

function updateHtml() {
	for (var y = 0; y < grid.length; y++) {
		for (var x = 0; x < grid[y].length; x++) {
			$('#cell' + y + x).removeClass();
			if (grid[y][x] == 0) {
				$('#cell' + y + x).addClass('player1');
			} else if (grid[y][x]) {
				$('#cell' + y + x).addClass('player2');
			}
		}
	}
}

function updateLight(x, y) {
	var lightInfo = {x: +x, y: +y + 1, bri: 255, on: true, color: {r: 0, g: 0, b: 0}};

	// Apply settings
	if (grid[y][x] == -1) {
		lightInfo.on = false;
	} else if (grid[y][x] == 0) {
		lightInfo.color.r = 255;
	} else {
		lightInfo.color.b = 255;
	}

	// Update light
	$.ajax({
    url        : address + '/light/',
    dataType   : 'json',
    contentType: 'application/json; charset=UTF-8', // This is the money shot
    data       : JSON.stringify(lightInfo),
    type       : 'POST',
    complete   : function(data) {}
	});
}

function updateLights() {
	for (var y = 0; y < grid.length; y++) {
		for (var x = 0; x < grid[y].length; x++) {
			updateLight(x, y);
		}
	}
}

/**
 Reset gameboard
*/
function reset() {
	grid = [[-1,-1,-1], [-1,-1,-1], [-1,-1,-1]];
	updateHtml();
}

/**
	Really ugly javascript function for checking for a winner (thanks Tristan for the introduction to programming course :-) )
 */
function checkWinner() {
	// horizontal, vertical, diagonal
	return ((grid[0][0] != -1 && grid[0][0] == grid[0][1] && grid[0][0] == grid[0][2]) ||
		  (grid[1][0] != -1 && grid[1][0] == grid[1][1] && grid[1][0] == grid[1][2]) ||
		  (grid[2][0] != -1 && grid[2][0] == grid[2][1] && grid[2][0] == grid[2][2]) ||
		  (grid[0][0] != -1 && grid[0][0] == grid[1][0] && grid[0][0] == grid[2][0]) ||
		  (grid[0][1] != -1 && grid[0][1] == grid[1][1] && grid[1][0] == grid[1][2]) ||
		  (grid[0][2] != -1 && grid[0][2] == grid[1][2] && grid[0][2] == grid[2][2]) ||
		  (grid[0][0] != -1 && grid[0][0] == grid[1][1] && grid[0][0] == grid[2][2]) ||
		  (grid[0][2] != -1 && grid[0][2] == grid[1][1] && grid[0][2] == grid[2][0]));
}

function isGameboardFull() {
	for (var y = 0; y < grid.length; y++) {
		for (var x = 0; x < grid[y].length; x++) {
			if (grid[y][x] == -1) {
				return false;
			}
		}
	}
	return true;
}