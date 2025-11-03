<?php
class Controller_Admin_Category extends Controller_Admin
{
    public function action_index()
    {
        $config = [
            'pagination_url' => \Uri::create('admin/categories'),
            'total_items'    => Model_Category::count(),
            'per_page'       => 10,
            'uri_segment'    => 'page',
            'template'       => 'bootstrap3',
        ];

        $pagination = \Pagination::forge('cat_pagination', $config);

        $data['categories'] = Model_Category::find('all', [
            'order_by' => ['id' => 'desc'],
            'limit'    => $pagination->per_page,
            'offset'   => $pagination->offset,
        ]);

        $data['pagination'] = $pagination->render();

        $view = \View::forge('admin/category/index', $data);
        return Service_Admin_Layout::render($view);
    }

    public function action_create()
    {
        if (\Input::method() == 'POST') {
            $val = Model_Category::validate('create');
            if ($val->run()) {
                $category = Model_Category::forge([
                    'name' => \Input::post('name'),
                    'description' => \Input::post('description'),
                ]);
                if ($category->save()) {
                    \Session::set_flash('success', 'Thêm danh mục thành công!');
                    \Response::redirect('admin/categories');
                } else {
                    \Session::set_flash('error', 'Lỗi khi lưu!');
                }
            } else {
                \Session::set_flash('validation_errors', $val->error());
                \Session::set_flash('old_input', \Input::post());
            }
        }

        $view = \View::forge('admin/category/create');
        return Service_Admin_Layout::render($view);
    }

    public function action_update($id = null)
    {
        $category = Model_Category::find($id);
        if (!$category) {
            \Session::set_flash('error', 'Danh mục không tồn tại!');
            \Response::redirect('admin/categories');
        }

        $val = Model_Category::validate('edit');

        if (\Input::method() == 'POST') {
            if ($val->run()) {
                $category->name = \Input::post('name');
                $category->description = \Input::post('description');
                if ($category->save()) {
                    \Session::set_flash('success', 'Cập nhật thành công!');
                    \Response::redirect('admin/categories');
                } else {
                    \Session::set_flash('error', 'Lỗi khi lưu!');
                }
            } else {
                \Session::set_flash('validation_errors', $val->error());
                \Session::set_flash('old_input', \Input::post());
            }
        }

        $view = \View::forge('admin/category/update')
            ->set('category', $category, false);
        return Service_Admin_Layout::render($view);
    }

    public function action_delete($id = null)
    {
        $category = Model_Category::find($id);
        if ($category && $category->delete()) {
            \Session::set_flash('success', 'Xóa thành công!');
        } else {
            \Session::set_flash('error', 'Xóa thất bại!');
        }
        \Response::redirect('admin/categories');
    }
}
