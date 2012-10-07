
#canvas {
	display: block;
  width: 500px;
  height: 500px;
	padding: 0;
	border: 0;
	overflow: visible;
  margin: 0 auto;
}

#canvas svg {
    width: 500px;
    height: 500px;
    display: block;
    border: 1px black solid;
    -webkit-user-select: none;
    cursor: crosshair;
    padding: 0;
    margin: 0;
    margin-top: 5px;
}

#canvaswrapper {
    overflow: visible;
}

#canvascolours {
    width: 26px;
    display: inline-block;
	vertical-align: top;
}

#canvascolours [data-colour] {
    width: 18px;
    height: 18px;
    margin-bottom: 10px;
    cursor: pointer;
    border: 1px black solid;
}

#realcanvas {
	display: none;
}

#linewidths {
	display: block;
}

.miniColors-triggerWrap {
	margin-left: 25px;
}

#save, #reset {
	display: block;
	width: 150px;
	text-align: center;
	padding: 10px 25px;
	margin: 0 auto;
	color: white;
	background-color: blue;
	border: 2px solid black;
	border-radius: 8px;
}

#colorSelector {
  width: 120px;
  margin: 0 auto;
}

.draw-sidebar {
  text-align: center;
}

#colorSelector-sample {
  display: inline-block;
  margin-left: 5px;
  height: 15px;
  width: 15px;
  background-color: #000000;
  vertical-align: middle;
}

#lineWidth-sample {
  display: inline-block;
  margin-left: 5px;
}

.elgg-form-draw-file input[name=container_guid] + div {
  display: none;
}