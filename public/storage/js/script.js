window.onload = async () => {
    await initTable();

}

const modal_edit = new bootstrap.Modal(document.getElementById('editModal'));
const checkModal = new bootstrap.Modal(document.getElementById('checkModal'));
const add_modal = new bootstrap.Modal(document.getElementById('addModal'));

$('#editModal').on('hide.bs.modal', (ev) => {
    $('.is-invalid').removeClass('is-invalid');
})

$('#checkModal').on('hide.bs.modal', (ev) => {
    $('.is-invalid').removeClass('is-invalid');
})

$('#addModal').on('hide.bs.modal', (ev) => {
    $('.is-invalid').removeClass('is-invalid');
})

async function getCategories() {
    return await axios('/api/getCategories')
        .then((response) => {
            return response['data']
        })
        .catch((error) => {
            console.log(error)
        })
}

function validate_form(data) {

    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');
    for (let key in data['errors']) {
        const error_feedback = $(`[name=${key}]`);
        error_feedback.addClass('is-invalid');
        data['errors'][key].forEach((err) => {
            $($(error_feedback.parent()).children('.invalid-feedback')).append(err + '<br>');
        })

    }

}

async function getOrder(id) {
    return await axios('/api/getOrder', {
        params: {
            order_id: id
        }
    })
        .then((response) => {
            return response['data']
        })
        .catch((error) => {
            console.log(error)
        })
}

async function getOrders(items_on_page = 10, search = '', page = 1) {
    return await axios.get('/api/getOrders', {
        params: {
            search: search,
            items_on_page: items_on_page,
            page: page
        }
    })
        .then((response) => {
            return response;
        })
        .catch((error) => {
            console.log(error);
        })
}

async function initTable(page = 1) {
    $('#data_table').empty();
    console.log(123)
    const search_value = $('#search').val();
    const items_on_page = $('#on_page_select option:selected').val();
    const data = await getOrders(items_on_page, search_value, page);
    let prev_page = data['data']['prev_page_url'] ? data['data']['current_page'] - 1 : null;
    let next_page = data['data']['next_page_url'] ? data['data']['current_page'] + 1 : null;

    $('#page_num').text(data['data']['from'] + '-' + data['data']['to'] + ' из ' + data['data']['total']);

    $('#on_page_select').off('change').on('change', (ev) => {

        initTable()
    })
    const left_arrow = $('#left_arrow');
    left_arrow.off('click')

    const right_arrow = $('#right_arrow');
    right_arrow.off('click')
    if (prev_page) {

        left_arrow.on('click', () => {
            initTable(prev_page)
        }).css('cursor', 'pointer')
    } else {
        left_arrow.css('cursor', 'default')
    }
    if (next_page) {

        right_arrow.on('click', () => {
            initTable(next_page)
        }).css('cursor', 'pointer')
    } else {
        right_arrow.css('cursor', 'default')
    }

    const orders = data['data']['data'];
    orders.forEach((order) => {
        const pyramid = order['pyramid_number'];
        const qty = order['qty'];
        const status = order['status'];
        const category = order['category']['name'];
        const id = order['id']
        const status_name = status === 0 ? ['Неактивно', 'inactive'] : ['Активно', 'active'];
        const category_elem = category === 'Заказчик' ? `<a href="#">${category}</a>` : category
        const order_html = `<tr>
                            <th scope="row">${id}</th>
                            <td>${pyramid}</td>
                            <td class="category_td">${category_elem}</td>
                            <td>${qty}</td>
                            <td><div class="status status-${status_name[1]}">${status_name[0]}</div></td>
                            <td class="edit_btn"><img src="/storage/img/edit.svg" alt="edit"></td>
                        </tr>`;
        $('#data_table').append(order_html);
    })

    // modal_edit
    $('.edit_btn').each((i, el) => {
        const id = $(el).parent().children('th')[0].innerHTML
        $(el).on('click', () => {
            openEditModal(id)
        })
    })

    $('.category_td>a').each((i, el) => {
        const id = $($($(el).parent()).parent()).children('th')[0].innerHTML;
        $(el).on('click', async () => {

            const order_data = await getOrder(id)
            console.log(order_data)
            $('#fio_check').text(order_data['fio'])
            $('#pyramid_number_check').text(order_data['pyramid_number']);
            $('#description_check').text(order_data['description']);
            checkModal.show();
        })
    })
}

async function openEditModal(id) {
    const order_data = await getOrder(id);

    const categories = await getCategories();
    const pyramid_number = order_data['pyramid_number'];
    const category = order_data['category']['id'];
    const qty = order_data['qty']
    const order_id = order_data['id']
    const status = order_data['status'];


    $('#select_edit').empty()
    categories.forEach((el) => {
        const selected = el['id'] === category ? 'selected' : ''
        $('#select_edit').append(`<option value="${el['id']}" ${selected}>${el['name']}</option>`)
    });
    $('#select_category').prop('value', category)
    $('#id').val(order_id)

    $('#pyramid_number').val(pyramid_number)
    $('#qty_edit').val(qty)
    $('#status_edit>option').each((i, el) => {
        if (Number($(el).val()) === status) {
            console.log(Number($(el).val()) === status)
            console.log(status)
            $(el).removeAttr('selected')
            $(el).attr('selected', 'selected')
        }
    })
    modal_edit.show();
}

$('#save_edit_btn').on('click', async (el) => {
    const form_data = $('#edit_save_form').serializeArray();
    let update_data = {}
    form_data.forEach((el) => {
        update_data[el['name']] = el['value']
    })
    await axios.put('/api/updateOrder', update_data)
        .then(async (response) => {
            modal_edit.hide();
            await initTable()
        })
        .catch((error) => {
            if (error.response.status === 422) {
                const data = error.response['data'];
                validate_form(data);

            }
        })


})

$('#add_btn').on('click', async (el) => {

    add_modal.show();
    $('#addModal').find('.form-control').val('')
    const categories = await getCategories();
    $('#select_add').empty();
    categories.forEach((el) => {
        $('#select_add').append(`<option value="${el['id']}">${el['name']}</option>`)
    });
})

$('#add_btn_form').on('click', async (el) => {
    const form_data = $('#add_order_form').serializeArray();
    let add_data = {}
    form_data.forEach((el) => {
        add_data[el['name']] = el['value']
    })
    await axios.post('/api/addOrder', add_data)
        .then(async (response) => {
            console.log(response)
            add_modal.hide()
            await initTable()
        })
        .catch((error) => {
            if (error.response.status === 422) {
                const data = error.response['data'];
                validate_form(data)
            }
        });

})

$('#search_btn').on('click', async (el) => {
    await initTable();
})

