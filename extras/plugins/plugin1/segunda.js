
    
    var words = [];
	var gamePuzzle;
	function Crear() {

	    datos = mytag[0].textContent.trim().split("×");

	    for (i = 0; i < (datos.length)-1; i++) {
	       words.push(datos[i]);

	    }
	    $('#Juegos').show();
	    gamePuzzle = wordfindgame.create(datos, '#juego', '#Palabras');
	    var puzzle = wordfind.newPuzzle(datos, { height: 18, width: 18, fillBlanks: false });
        wordfind.print(puzzle);
      }
		$('#solve').click( function() {wordfindgame.solve(gamePuzzle, words);});
    