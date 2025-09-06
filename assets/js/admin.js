document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de Vendas por Categoria
    const salesByCategoryCtx = document.getElementById('salesByCategoryChart');
    if (salesByCategoryCtx) {
        new Chart(salesByCategoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Eletrônicos', 'Acessórios', 'Periféricos'],
                datasets: [{
                    label: 'Vendas por Categoria',
                    data: [45, 25, 30],
                    backgroundColor: [
                        'rgba(66, 133, 244, 0.8)', // Azul Google
                        'rgba(52, 168, 83, 0.8)', // Verde Google
                        'rgba(251, 188, 5, 0.8)'   // Amarelo Google
                    ],
                    borderColor: [
                        'rgba(66, 133, 244, 1)',
                        'rgba(52, 168, 83, 1)',
                        'rgba(251, 188, 5, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Distribuição de Vendas por Categoria'
                    }
                }
            }
        });
    }

    // Lógica para o modal de edição de produto
    const editProductModal = document.getElementById('editProductModal');
    if (editProductModal) {
        editProductModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const productId = button.getAttribute('data-id');

            // Faz uma requisição para buscar os dados do produto
            fetch(`get_product.php?id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        const modalTitle = editProductModal.querySelector('.modal-title');
                        const productIdInput = editProductModal.querySelector('#editProductId');
                        const productNameInput = editProductModal.querySelector('#editProductName');
                        const productDescriptionInput = editProductModal.querySelector('#editProductDescription');
                        const productPriceInput = editProductModal.querySelector('#editProductPrice');
                        const productQuantityInput = editProductModal.querySelector('#editProductQuantity');

                        modalTitle.textContent = `Editar Produto: ${data.name}`;
                        productIdInput.value = data.id;
                        productNameInput.value = data.name;
                        productDescriptionInput.value = data.description;
                        productPriceInput.value = data.price;
                        productQuantityInput.value = data.quantity;
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar dados do produto:', error);
                    alert('Ocorreu um erro ao buscar os dados do produto.');
                });
        });
    }

    // Lógica para o modal de edição de usuário
    const editUserModal = document.getElementById('editUserModal');
    if (editUserModal) {
        editUserModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-id');

            // Faz uma requisição para buscar os dados do usuário
            fetch(`get_user.php?id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        const modalTitle = editUserModal.querySelector('.modal-title');
                        const userIdInput = editUserModal.querySelector('#editUserId');
                        const userNameInput = editUserModal.querySelector('#editUserName');
                        const userEmailInput = editUserModal.querySelector('#editUserEmail');
                        const userTypeInput = editUserModal.querySelector('#editUserType');

                        modalTitle.textContent = `Editar Usuário: ${data.username}`;
                        userIdInput.value = data.id;
                        userNameInput.value = data.username;
                        userEmailInput.value = data.email;
                        userTypeInput.value = data.user_type;
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar dados do usuário:', error);
                    alert('Ocorreu um erro ao buscar os dados do usuário.');
                });
        });
    }
});