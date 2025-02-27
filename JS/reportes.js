document.addEventListener("DOMContentLoaded", function () {
  // Datos de ejemplo
  const usuarios = [
    {
      nombre: "Juan Alberto Pérez Rodriguez",
      correo: "juan@example.com",
      ultimoIngreso: "2025-02-25",
    },
    {
      nombre: "María López",
      correo: "maria@example.com",
      ultimoIngreso: "2025-02-24",
    },
    // Agrega más usuarios aquí
  ];

  const posts = [
    {
      titulo: "Primer Post",
      usuario: "juan@example.com",
      fechaCreacion: "2025-01-15",
    },
    {
      titulo: "Segundo Post",
      usuario: "maria@example.com",
      fechaCreacion: "2025-01-20",
    },
    // Agrega más posts aquí
  ];

  // Llenar reporte de usuarios
  const totalUsuarios = document.getElementById("total-usuarios");
  const usuariosLista = document.getElementById("usuarios-lista");
  totalUsuarios.textContent = usuarios.length;
  usuarios.forEach((usuario) => {
    const row = document.createElement("tr");
    row.innerHTML = `
        <td>${usuario.nombre}</td>
        <td>${usuario.correo}</td>
        <td>${usuario.ultimoIngreso}</td>
      `;
    usuariosLista.appendChild(row);
  });

  // Llenar reporte de posts
  const totalPosts = document.getElementById("total-posts");
  const postsLista = document.getElementById("posts-lista");
  totalPosts.textContent = posts.length;
  posts.forEach((post) => {
    const row = document.createElement("tr");
    row.innerHTML = `
        <td>${post.titulo}</td>
        <td>${post.usuario}</td>
        <td>${post.fechaCreacion}</td>
      `;
    postsLista.appendChild(row);
  });
});
