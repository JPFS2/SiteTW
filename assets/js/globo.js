// globo.js
import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.150.1/build/three.module.js';


document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById('globo-container');

  if (!container) return;

  const width = container.offsetWidth;
  const height = 400; // valor fixo opcional

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(60, width / height, 0.1, 1000);
  camera.position.z = 5;

  const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
  renderer.setSize(width, height);
  container.appendChild(renderer.domElement);

  const light = new THREE.AmbientLight(0xffffff, 1);
  scene.add(light);

  const loader = new THREE.TextureLoader();
  loader.load(
    'https://raw.githubusercontent.com/jeromeetienne/threex.planets/master/images/earthmap1k.jpg',
    function (texture) {
      const geometry = new THREE.SphereGeometry(2, 64, 64);
      const material = new THREE.MeshStandardMaterial({ map: texture });
      const earth = new THREE.Mesh(geometry, material);
      scene.add(earth);

      function animate() {
        requestAnimationFrame(animate);
        earth.rotation.y += 0.002;
        renderer.render(scene, camera);
      }

      animate();
    },
    undefined,
    function (err) {
      console.error('Erro ao carregar a textura:', err);
    }
  );
});
