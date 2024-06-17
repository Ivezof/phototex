<!doctype html>
<html lang="ru">
<head>
    @include('parts.head', ['title' => 'Панель управления'])
</head>
<body style="background-color: white !important;">
    <div class="content">
        <div class="page-head">
            <p class="name-page">CRM PHOTOTEH</p>
            <div class="line"></div>
        </div>
        <div class="table-content">
            <div class="head-table">
                <div class="search">
                    <img src="{{ asset('storage/img/search.svg') }}" alt="" class="search-icon" id="search_btn">
                    <label for="search">
                    </label>
                    <input type="text" id="search" class="search-input" placeholder="Поиск по наименованию и категории">
                </div>
                <div class="btns">
                    <div class="btn_add btn" id="add_btn">Добавить</div>
                    <a href="{{ route('logout') }}" class="logout-btn btn">Выйти</a>
                </div>

            </div>
            <div>

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Номер пирамиды</th>
                        <th scope="col">Категория</th>
                        <th scope="col">ед/изм.</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="data_table">

                    </tbody>
                </table>
                <div class="pagination">
                    <div class="on_page">
                        <p class="on_page_text">Показывать на странице:</p>
                        <select class="form-select" aria-label="Default select example" id="on_page_select">
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                    </div>
                    <div class="page_scroll">
                        <p class="page_num" id="page_num">1-10 из 200</p>
                        <div class="page_arrows">
                            <img src="{{ asset('storage/img/left_arrow.svg') }}" alt="" class="arrow" id="left_arrow">
                            <img src="{{ asset('storage/img/left_arrow.svg') }}" alt="" class="arrow arrow_right" id="right_arrow">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактирование</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="edit_save_form">
                            <input hidden id="id" name="id" class="form-control">
                            <div class="mb-3">
                                <label for="pyramid_number" class="label-modal">Номер пирамиды</label>
                                <input id="pyramid_number" name="pyramid_number" class="form-control">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="label-modal">Категория</label>
                                <select class="form-select" id="select_edit" name="category" aria-label="Default select example">
                                    <option id="select_category">Выберите категорию</option>
                                </select>
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="label-modal" for="qty_edit">Ед/изм</label>
                                <input id="qty_edit" name="qty" class="form-control">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <label class="label-modal">Статус</label>
                            <select class="form-select" id="status_edit" name="status" aria-label="Default select example">
                                <option value="0">Неактивно</option>
                                <option value="1">Активно</option>
                            </select>
                            <div class="invalid-feedback">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary" id="save_edit_btn">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="addModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Добавление</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="add_order_form">
                            <div class="mb-3">
                                <label for="pyramid_number" class="label-modal">Номер пирамиды</label>
                                <input id="pyramid_number" name="pyramid_number" class="form-control">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="label-modal">Категория</label>
                                <select class="form-select" id="select_add" name="category" aria-label="Default select example">
                                </select>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="fio" class="label-modal">ФИО</label>
                                <input id="fio" name="fio" class="form-control">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="label-modal">Описание</label>
                                <textarea id="description" name="description" class="form-control"></textarea>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="label-modal" for="qty_edit">Ед/изм</label>
                                <input id="qty_edit" name="qty" class="form-control">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary" id="add_btn_form">Добавить</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal" tabindex="-1" id="checkModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Просмотр</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>ФИО заказчика: <span id="fio_check" class="span_black"></span></p>
                        <p>Номер заказа: <span id="pyramid_number_check" class="span_black"></span></p>
                        <p>Комментарий:<br><span id="description_check" class="span_black"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        @include('parts.footer')
    </div>
</body>
</html>
