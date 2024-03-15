function createArc(x, y, radius, startAngle, endAngle, fill, stroke, strokeWidth) {
  const arc = this.renderer.arc(x, y, radius, radius, startAngle, endAngle);
  const path = arc.attr({
    fill,
    stroke,
    'stroke-width': strokeWidth
  });
  arc.add(path);
  return path;
}

createArc.call(
  {
    renderer: someRenderer // replace with your renderer instance
  },
  200, 150, 100, -Math.PI, 0, '#FCFFC5', 'black', 1
);
