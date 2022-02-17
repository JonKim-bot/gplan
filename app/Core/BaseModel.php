<?php





namespace App\Core;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $tableName;


    protected $primaryKey = 0;

    protected $helpers = ['url', 'form', 'infector', 'session'];

    public function __construct()

    {
        parent::__construct();

        $this->fetchTable();
        $this->fetchTablePrimaryKey();

        // $session = \Config\Services::session();
        $session = session();
        $uri = service('uri');

        $this->builder = $this->db->table($this->tableName);
        $this->sql = '';

        // $this->AdminModel = new AdminModel();
        // $this->UsersModel = new UsersModel();
    }

    // public function 
    /**
     * Guess the table name by the model name
     */

    protected function fetchTable()
    {
        if ($this->tableName == null) {
            $this->tableName = preg_replace(
                '/(M|Model)?$/',
                '',
                get_class($this)
            );
            $this->tableName = substr($this->tableName, 11);
            $this->tableName = preg_split('/(?=[A-Z])/', $this->tableName);
            unset($this->tableName[0]);
            $tableName = '';
            foreach ($this->tableName as $row) {
                $tableName .= $row . '_';
            }
            $this->tableName = substr($tableName, 0, -1);
            $this->tableName = strtolower($this->tableName);
        }
    }

    /**
     * Guess the table name by the model name + '_id'
     */

    protected function fetchTablePrimaryKey()
    {
        if ($this->primaryKey == null) {
            $this->primaryKey = preg_replace(
                '/(M|Model)?$/',
                '',
                get_class($this)
            );
            $this->primaryKey = substr($this->primaryKey, 11);
            $this->primaryKey = preg_split('/(?=[A-Z])/', $this->primaryKey);
            unset($this->primaryKey[0]);
            $primaryKey = '';
            foreach ($this->primaryKey as $row) {
                $primaryKey .= $row . '_';
            }
            $this->primaryKey = substr($primaryKey, 0, -1);
            $this->primaryKey .= '_id';
            $this->primaryKey = strtolower($this->primaryKey);
        }
    }

    public function getAll($limit = '', $page = 1, $filter = [])
    {
        // $this->builder = $this->db->table($this->tableName);
        // $this->builder->select('*');

        // $query = $this->builder->get();
        // return $query->getResultArray();

        // $fields = $this->db->getFieldNames($this->tableName);

        $deleted = false;
        // foreach ($fields as $row) {
        //     if ($row == "deleted") {
        //         $deleted = true;
        //     }
        // }

        $this->setRunningNo();

        $this->builder->select('*');
        $this->builder->orderBy($this->tableName . '_id', 'desc');

        // if ($deleted) {
        $this->builder->where($this->tableName . '.deleted', 0);
        // }

        $this->builder->where($this->tableName . '.deleted', 0);

        // die($this->builder->getCompiledSelect(false));

        if ($limit != '') {
            $count = $this->getCount($filter);
            $offset = ($page - 1) * $limit;
            $pages = $count / $limit;
            $pages = ceil($pages);

            $pagination = $this->getPaging(
                $limit,
                $offset,
                $page,

                $pages,
                $filter
            );

            return $pagination;

            // intval($limit);
            // $this->db->limit($limit, $offset);
        }
        $this->builder->orderBy($this->tableName . '.' . $this->primaryKey,'DESC');

        $query = $this->builder->get();
        return $query->getResultArray();
    }

    public function unset_array($orgininal)
    {
        $filter = [
            'deleted',
            'created_date',
            'created_at',
            'modified_date',
            'modified_by',
            'created_by',
        ];

        foreach ($filter as $key => $row) {
            unset($orgininal[$row]);
        }

        return $orgininal;
    }
    public function get_field($filter = [], $realtable = [])
    {
        $fields = $this->db->getFieldData($this->tableName);

        if (!empty($realtable)) {
            // $fields = $realtable[0];

            $fields = array_keys($realtable[0]);
            $header = array_combine($fields, $fields);
            // dd($header);
            $field = $this->unset_array_filter($filter, $header);
            return $field;
        } else {
            $fields_arr = [];
            // $this->primaryKey .= "_id";
            // $this->primaryKey = strtolower($this->primaryKey);
            foreach ($fields as $row) {
                if ($row->name != $this->primaryKey) {
                    //exclude primary key
                    array_push($fields_arr, $row->name);
                }
            }
            if (!empty($filter)) {
                $final_array = array_combine($fields_arr, $fields_arr);
                $fields_arr = $this->unset_array_filter($filter, $final_array);
            }

            return $fields_arr;
        }
    }
    
    public function unset_array_filter($filter, $orgininal)
    {
        foreach ($filter as $key => $row) {
            foreach ($orgininal as $dual_key => $ori) {
                unset($orgininal[$row]);
            }
        }
        return $orgininal;
    }

    // public function unset_array_filter($filter, $orgininal)
    // {
    //     foreach ($filter as $key => $row) {
    //         foreach ($orgininal as $dual_key => $ori) {

    //             unset($orgininal[$dual_key][$row]);
    //         }
    //     }

    //     return $orgininal;
    // }

    public function generate_input()
    {
        $fields = $this->db->getFieldData($this->tableName);

        $input_fields = [];
        foreach ($fields as $row) {
            $label = ucwords(str_replace('_', ' ', $row->name));

            $html = '<div class="form-group">';
            if (
                ($row->type == 'int' or $row->type == 'decimal') and
                substr($row->name, -3) != '_id'
            ) {
                $html .=
                    '<label for="form_' .
                    $row->name .
                    '">' .
                    $label .
                    '</label><span style="color:red">*</span>';
                $html .=
                    '<input type="number" class="form-control" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '" required step="any">';
            } elseif (
                $row->type == 'longtext' or
                $row->type == 'text' or
                $row->type == 'longblob'
            ) {
                $html .=
                    '<label for="form_' .
                    $row->name .
                    '">' .
                    $label .
                    '</label>';
                $html .=
                    '<textarea class="form-control" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '" required rows="5"></textarea>';
            } elseif (
                $row->name == 'thumbnail' or
                $row->name == 'image' or
                $row->name == 'banner' or
                $row->name == 'banner_xs'
            ) {
                $html .=
                    '<div id="preview_' .
                    $row->name .
                    '" class="upload_preview"></div>';

                $html .=
                    '<label for="form_' .
                    $row->name .
                    '">' .
                    
                    $label .
                    '</label>';
                $html .=
                    '<input type="file" class="form-control image_input" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '" required>';
            } elseif ($row->name == 'password') {
                $html .=
                    '<label for="form_' .
                    $row->name .
                    '">' .
                    $label .
                    '</label>';
                $html .=
                    '<input type="password" class="form-control" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '" required>';
            } elseif ($row->name == 'email') {
                $html .=
                    '<label for="form_' .
                    $row->name .
                    '">' .
                    $label .
                    '</label>';
                $html .=
                    '<input type="email" class="form-control" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '" required>';
                    
            } elseif ($row->type == 'date') {
                $html .=
                    '<label for="form_' .
                    $row->name .
                    '">' .
                    $label .
                    '</label>';
                $html .=
                    '<input type="text" class="form-control datepicker" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    
                    $row->name .
                    '" required>';
            } elseif (
                substr($row->name, -3) == '_id' and
                substr($row->name, 0, -3) != $this->tableName
            ) {
                if (
                    $this->db->tableExists(substr($row->name, 0, -3)) or
                    substr($row->name, 0, -3) == 'parent'
                ) {
                    if (substr($row->name, 0, -3) == 'parent') {
                        $fields = $this->db->getFieldNames($this->tableName);
                        
                    } else {
                        $fields = $this->db->getFieldNames(
                            substr($row->name, 0, -3)
                        );
                    }

                    $field_exists = false;
                    $use_name = false;
                    $use_label = false;
                    $use_role = false;
                    $duplicate_of = false;

                    foreach ($fields as $field_row) {
                        if ($field_row == 'duplicate_of') {
                            $duplicate_of = true;
                        }

                        if (substr($row->name, 0, -3) == 'parent') {
                            $field_exists = true;
                        }

                        if ($field_row == substr($row->name, 0, -3)) {
                            $field_exists = true;
                        } elseif ($field_row == 'name') {
                            $field_exists = true;
                            $use_name = true;
                        } elseif ($field_row == 'label') {
                            $field_exists = true;
                            $use_label = true;
                        } elseif ($field_row == 'role') {
                            $field_exists = true;
                            $use_role = true;
                        } elseif ($field_row == 'product_name') {
                            $field_exists = true;
                            $use_role = true;
                        }
                    }

                    if ($field_exists) {
                        $table_namee = str_replace('_id', '', $row->name);
                        $this->builder = $this->db->table($table_namee);

                        $this->builder->select('*');

                        if (substr($row->name, 0, -3) == 'parent') {
                            // $this->builder->from($this->tableName);

                            $this->builder->where(
                                $this->tableName . '.deleted',
                                0
                            );
                            if ($duplicate_of) {
                                $this->builder->where(
                                    $this->tableName . '.duplicate_of',
                                    0
                                );
                            }
                        } else {
                            // $this->builder->from(substr($row->name, 0, -3));

                            $this->builder->where(
                                substr($row->name, 0, -3) . '.deleted',
                                0
                            );
                            if ($duplicate_of) {
                                $this->builder->where(
                                    substr($row->name, 0, -3) . '.duplicate_of',
                                    0
                                );
                                
                            }
                        }

                        if (substr($row->name, 0, -3) == 'role') {
                            $this->builder->where(
                                'type',
                                strtoupper($this->tableName)
                            );
                            //if the table contain role_id column
                        }

                        $query = $this->builder->get();

                        $result = $query->getResultArray();
                        $temp_label_name = ucwords(
                            str_replace('_', ' ', $row->name)
                        );
                        // $this->debug(ucwords(substr($row->name, 0, -3)));

                        if (substr($row->name, 0, -3) == 'parent') {
                            $html .=
                                '<label for="form_' .
                                $row->name .
                                '">Parent</label>';
                        } else {
                            $html .=
                                '<label for="form_' .
                                $row->name .
                                '">' .
                                ucwords(substr($temp_label_name, 0, -3)) .
                                '</label>';
                        }
                        $html .=
                            '<select class="form-control select2" id="form_' .
                            $row->name .
                            '" name="' .
                            $row->name .
                            '">';
                        foreach ($result as $result_row) {
                            if ($use_name) {
                                $html .=
                                    '<option value="' .
                                    $result_row[
                                        substr($row->name, 0, -3) . '_id'
                                    ] .
                                    '">' .
                                    $result_row['name'] .
                                    '</option>';
                            } elseif ($use_label) {
                                $html .=
                                    '<option value="' .
                                    $result_row[
                                        substr($row->name, 0, -3) . '_id'
                                    ] .
                                    '">' .
                                    $result_row['label'] .
                                    '</option>';
                            } elseif ($use_role) {
                                $html .=
                                    '<option value="' .
                                    $result_row[
                                        substr($row->name, 0, -3) . '_id'
                                    ] .
                                    '">' .
                                    $result_row['role'] .
                                    '</option>';
                            } else {
                                if (substr($row->name, 0, -3) == 'parent') {
                                    $html .=
                                        '<option value="' .
                                        $result_row[
                                            substr($row->name, 0, -3) . '_id'
                                        ] .
                                        '">' .
                                        $result_row[$this->tableName] .
                                        '</option>';
                                } else {
                                    //generate input field with role id

                                    $html .=
                                        '<option value="' .
                                        $result_row[
                                            substr($row->name, 0, -3) . '_id'
                                        ] .
                                        '">' .
                                        $result_row[substr($row->name, 0, -3)] .
                                        '</option>';
                                }
                            }
                        }
                        $html .= '</select>';
                    } else {
                        $html .=
                            '<label for="form_' .
                            $row->name .
                            '">' .
                            $label .
                            '</label>';
                        $html .=
                            '<input type="text" class="form-control" id="form_' .
                            $row->name .
                            '" placeholder="' .
                            $label .
                            '" name="' .
                            $row->name .
                            '" required>';
                    }
                } elseif (substr($row->name, 0, -3) == 'parent') {
                    $fields = $this->db->getFieldNames($this->tableName);

                    $field_exists = false;
                    $use_name = false;
                    $use_label = false;
                    $use_role = false;
                    $duplicate_of = false;
                    foreach ($fields as $field_row) {
                        if ($field_row == 'duplicate_of') {
                            $duplicate_of = true;
                        }

                        if ($field_row == substr($row->name, 0, -3)) {
                            $field_exists = true;
                        } elseif ($field_row == 'name') {
                            $field_exists = true;
                            $use_name = true;
                        } elseif ($field_row == 'label') {
                            $field_exists = true;
                            $use_role = true;
                        } elseif ($field_row == 'role') {
                            $field_exists = true;
                            $use_role = true;
                        }
                    }

                    $html .=
                        '<label for="form_' . $row->name . '">Parent</label>';
                    $html .=
                        '<select class="form-control select2" id="form_' .
                        $row->name .
                        '" name="' .
                        $row->name .
                        '">';
                    $html .= '<option value="0">None</option>';
                    foreach ($self_data as $self_data_row) {
                        $html .=
                            '<option value="' .
                            $self_data_row[$this->tableName . '_id'] .
                            '">' .
                            $self_data_row[$this->tableName] .
                            '</option>';
                    }
                    $html .= '</select>';
                }
            } else {
                if ($row->name == 'contact') {
                    $html .=
                        '<label for="form_' .
                        $row->name .
                        '">Contact Number</label>';
                } else {
                    $html .=
                        '<label for="form_' .
                        $row->name .
                        '">' .
                        $label .
                        '</label>';
                }
                $html .=
                    '<input type="text" class="form-control" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '" required>';

            }
            $html .= '<div class="help-block with-errors"></div>';
            $html .= '</div>';

            $input_fields[$row->name] = $html;
            if ($row->name == 'password') {
                $html = '<div class="form-group">';
                $html .= '<label for="form_password2">Confirm Password</label>';
                $html .=
                    '<input type="password" class="form-control" id="form_password2" placeholder="Confirm Password" name="password2" required>';
                $html .= '<div class="help-block with-errors"></div>';
                $html .= '</div>';
                $input_fields['password2'] = $html;
            }
        }

        return $this->unset_array($input_fields);
    }

    public function generate_edit_input($primary_key)
    {
        $data = $this->getWhere([
            $this->tableName . '.' . $this->primaryKey => $primary_key,
        ])[0];

        $fields = $this->db->getFieldData($this->tableName);

        $input_fields = [];
        foreach ($fields as $row) {
            $label = ucwords(str_replace('_', ' ', $row->name));

            $html = '<div class="form-group">';

            if (
                ($row->type == 'int' or $row->type == 'decimal') and
                substr($row->name, -3) != '_id'
            ) {
                $html .=
                    '<label for="form_' .
                    $row->name .
                    '">' .
                    $label .
                    '</label>';
                $html .=
                    '<input type="number" class="form-control" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '" required value="' .
                    $data[$row->name] .
                    '" step="any">';
            } elseif (
                $row->type == 'longtext' or
                $row->type == 'text' or
                $row->type == 'longblob'
            ) {
                $html .=
                    '<label for="form_' .
                    $row->name .
                    '">' .
                    $label .
                    '</label>';
                $html .=
                    '<textarea class="form-control" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '" required rows="5">' .
                    $data[$row->name] .
                    '</textarea>';
            } elseif (
                $row->name == 'thumbnail' or
                $row->name == 'image' or
                $row->name == 'banner' or
                $row->name == 'banner_xs'
            ) {
                $html .=
                    '<div id="preview_' .
                    $row->name .
                    '" class="upload_preview"></div>';
                $html .=
                    '<label for="form_' .
                    $row->name .
                    '">' .
                    $label .
                    ' <small>*leave blank to keep previous image</small></label>';
                $html .=
                    '<input type="file" class="form-control image_input" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '">';
            } elseif ($row->name == 'password') {
                $html .=
                    '<label for="form_' .
                    $row->name .
                    '">Password <small>*leave blank to keep old password</small></label>';
                $html .=
                    '<input type="password" class="form-control" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '" >';
            } elseif ($row->name == 'email') {
                $html .=
                    '<label for="form_' .
                    $row->name .
                    '">' .
                    $label .
                    '</label>';
                $html .=
                    '<input type="email" class="form-control" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '" required value="' .
                    $data[$row->name] .
                    '">';
            } elseif ($row->type == 'date') {
                $html .=
                    '<label for="form_' .
                    $row->name .
                    '">' .
                    $label .
                    '</label>';
                $html .=
                    '<input type="text" class="form-control datepicker" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '" required value="' .
                    date('d-m-Y', strtotime($data[$row->name])) .
                    '">';
            } elseif (
                substr($row->name, -3) == '_id' and
                substr($row->name, 0, -3) != $this->tableName
            ) {
                if (
                    $this->db->tableExists(substr($row->name, 0, -3)) or
                    substr($row->name, 0, -3) == 'parent'
                ) {
                    if (substr($row->name, 0, -3) == 'parent') {
                        $fields = $this->db->getFieldNames($this->tableName);
                    } else {
                        $fields = $this->db->getFieldNames(
                            substr($row->name, 0, -3)
                        );
                    }

                    $field_exists = false;
                    $use_name = false;
                    $use_label = false;
                    $use_role = false;
                    $duplicate_of = false;
                    // dd($fields);
                    foreach ($fields as $field_row) {
                        if ($field_row == 'duplicate_of') {
                            $duplicate_of = true;
                        }

                        if (substr($row->name, 0, -3) == 'parent') {
                            $field_exists = true;
                        }

                        if ($field_row == substr($row->name, 0, -3)) {
                            $field_exists = true;
                        } elseif ($field_row == 'name') {
                            $field_exists = true;
                            $use_name = true;
                        } elseif ($field_row == 'label') {
                            $field_exists = true;
                            $use_label = true;
                        } elseif ($field_row == 'role') {
                            $field_exists = true;
                            $use_role = true;
                        }
                    }

                    if ($field_exists) {
                        $table_namee = str_replace('_id', '', $row->name);
                        $this->builder = $this->db->table($table_namee);

                        $this->builder->select('*');
                        if (substr($row->name, 0, -3) == 'parent') {
                            $this->builder->from($this->tableName);
                            $this->builder->where(
                                $this->tableName . '.deleted',
                                0
                            );

                            if ($duplicate_of) {
                                $this->builder->where(
                                    $this->tableName . '.duplicate_of',
                                    0
                                );
                            }
                        } else {
                            // $this->builder->from(substr($row->name, 0, -3));
                            $this->builder->where(
                                substr($row->name, 0, -3) . '.deleted',
                                0
                            );
                            if ($duplicate_of) {
                                $this->builder->where(
                                    substr($row->name, 0, -3) . '.duplicate_of',
                                    0
                                );
                            }
                        }
                        if (substr($row->name, 0, -3) == 'role') {
                            $this->builder->where(
                                'type',
                                strtoupper($this->tableName)
                            );
                        }

                        $query = $this->builder->get();

                        $result = $query->getResultArray();

                        $temp_label_name = ucwords(
                            str_replace('_', ' ', $row->name)
                        );
                        // $this->debug(ucwords(substr($row->name, 0, -3)));

                        $html .=
                            '<label for="form_' .
                            $row->name .
                            '">' .
                            ucwords(substr($temp_label_name, 0, -3)) .
                            '</label>';
                        $html .=
                            '<select class="form-control select2" id="form_' .
                            $row->name .
                            '" name="' .
                            $row->name .
                            '">';
                        if (substr($row->name, 0, -3) == 'parent') {
                            $html .= '<option value="0">None</option>';
                        }
                        foreach ($result as $result_row) {
                            if ($use_name) {
                                if (
                                    $result_row[$row->name] == $data[$row->name]
                                ) {
                                    $html .=
                                        '<option value="' .
                                        $result_row[$row->name] .
                                        '" selected>' .
                                        $result_row['name'] .
                                        '</option>';
                                } else {
                                    $html .=
                                        '<option value="' .
                                        $result_row[$row->name] .
                                        '">' .
                                        $result_row['name'] .
                                        '</option>';
                                }
                                // $html .= '<option value="' . $result_row[substr($row->name, 0, -3) . '_id'] . '">' . $result_row['name'] . '</option>';
                            } elseif ($use_label) {
                                if (
                                    $result_row[$row->name] == $data[$row->name]
                                ) {
                                    $html .=
                                        '<option value="' .
                                        $result_row[$row->name] .
                                        '" selected>' .
                                        $result_row['label'] .
                                        '</option>';
                                } else {
                                    $html .=
                                        '<option value="' .
                                        $result_row[$row->name] .
                                        '">' .
                                        $result_row['label'] .
                                        '</option>';
                                }
                                // $html .= '<option value="' . $result_row[substr($row->name, 0, -3) . '_id'] . '">' . $result_row['name'] . '</option>';
                            } elseif ($use_role) {
                                if (
                                    $result_row[$row->name] == $data[$row->name]
                                ) {
                                    $html .=
                                        '<option value="' .
                                        $result_row[$row->name] .
                                        '" selected>' .
                                        $result_row['role'] .
                                        '</option>';
                                } else {
                                    $html .=
                                        '<option value="' .
                                        $result_row[$row->name] .
                                        '">' .
                                        $result_row['role'] .
                                        '</option>';
                                }
                                // $html .= '<option value="' . $result_row[substr($row->name, 0, -3) . '_id'] . '">' . $result_row['name'] . '</option>';
                            } else {
                                if (
                                    $result_row[$row->name] == $data[$row->name]
                                ) {
                                    if (substr($row->name, 0, -3) == 'parent') {
                                        $html .=
                                            '<option value="' .
                                            $result_row[$row->name] .
                                            '" selected>' .
                                            $result_row[$this->tableName] .
                                            '</option>';
                                    } else {
                                        $html .=
                                            '<option value="' .
                                            $result_row[$row->name] .
                                            '" selected>' .
                                            $result_row[
                                                substr($row->name, 0, -3)
                                            ] .
                                            '</option>';
                                    }
                                } else {
                                    if (substr($row->name, 0, -3) == 'parent') {
                                        $html .=
                                            '<option value="' .
                                            $result_row[$row->name] .
                                            '">' .
                                            $result_row[$this->tableName] .
                                            '</option>';
                                    } else {
                                        $html .=
                                            '<option value="' .
                                            $result_row[$row->name] .
                                            '">' .
                                            $result_row[
                                                substr($row->name, 0, -3)
                                            ] .
                                            '</option>';
                                    }
                                }
                            }
                        }
                        $html .= '</select>';
                    } else {
                        $html .=
                            '<label for="form_' .
                            $row->name .
                            '">' .
                            $label .
                            '</label>';
                        $html .=
                            '<input type="text" class="form-control" id="form_' .
                            $row->name .
                            '" placeholder="' .
                            $label .
                            '" name="' .
                            $row->name .
                            '" required value="' .
                            $data[$row->name] .
                            '">';
                    }
                } elseif (substr($row->name, 0, -3) == 'parent') {
                    $self_data = $this->getWhere(
                        $where = [
                            $this->tableName . '_id != ' => $primary_key,
                        ]
                    );
                    $html .=
                        '<label for="form_' . $row->name . '">Parent</label>';
                    $html .=
                        '<select class="form-control select2" id="form_' .
                        $row->name .
                        '" name="' .
                        $row->name .
                        '">';
                    $html .= '<option value="0">None</option>';
                    foreach ($self_data as $self_data_row) {
                        if (
                            $self_data_row[$this->tableName . '_id'] ==
                            $data[$row->name]
                        ) {
                            $html .=
                                '<option value="' .
                                $self_data_row[$this->tableName . '_id'] .
                                '" selected>' .
                                $self_data_row[$this->tableName] .
                                '</option>';
                        } else {
                            $html .=
                                '<option value="' .
                                $self_data_row[$this->tableName . '_id'] .
                                '">' .
                                $self_data_row[$this->tableName] .
                                '</option>';
                        }
                    }
                    $html .= '</select>';
                }
            } else {
                if ($row->name == 'contact') {
                    $html .=
                        '<label for="form_' .
                        $row->name .
                        '">Contact Number</label>';
                } else {
                    $html .=
                        '<label for="form_' .
                        $row->name .
                        '">' .
                        $label .
                        '</label>';
                }
                $html .=
                    '<input type="text" class="form-control" id="form_' .
                    $row->name .
                    '" placeholder="' .
                    $label .
                    '" name="' .
                    $row->name .
                    '" required value="' .
                    $data[$row->name] .
                    '">';
            }
            $html .= '<div class="help-block with-errors"></div>';
            $html .= '</div>';

            $input_fields[$row->name] = $html;
            if ($row->name == 'password') {
                $html = '<div class="form-group">';
                $html .=
                    '<label for="form_password2">Confirm Password <small>*leave blank to keep old password</small></label>';
                $html .=
                    '<input type="password" class="form-control" id="form_password2" placeholder="Confirm Password" name="password2">';
                $html .= '<div class="help-block with-errors"></div>';
                $html .= '</div>';
                $input_fields['password2'] = $html;
            }
        }

        return $this->unset_array($input_fields);
    }
    

    public function processSql($sql){
        
        $result = $this->db->query($sql)->getResultArray();

        return $result;

    }

    public function getLike($like, $limit = '', $page = 1, $filter = [])
    {
        $this->builder->select('*');

        $this->builder->like($like);

        if ($limit != '') {
            $count = $this->getCount($filter);
            $offset = ($page - 1) * $limit;
            $pages = $count / $limit;
            $pages = ceil($pages);
            $pagination = $this->getPaging(
                $limit,
                $offset,
                $page,
                $pages,
                $filter
            );

            return $pagination;

            // intval($limit);
            // $this->db->limit($limit, $offset);
        }

        $query = $this->builder->get();
        return $query->getResultArray();
    }
    public function getWhereDeleted($where, $limit = '', $page = 1, $filter = [])
    {
        $this->builder->select('*');
        // $this->builder->where($this->tableName . '.deleted', 1);
        $this->builder->where($where);

        if ($limit != '') {
            $count = $this->getCount($filter);
            $offset = ($page - 1) * $limit;
            $pages = $count / $limit;
            $pages = ceil($pages);
            $pagination = $this->getPaging(
                $limit,

                $offset,
                $page,
                $pages,
                $filter
            );

            return $pagination;

            // intval($limit);
            // $this->db->limit($limit, $offset);
        }

        // if(!empty($where['customer_id'])){
        //     die($this->builder->getCompiledSelect(false));
        // }

        $query = $this->builder->get();

        return $query->getResultArray();

    }

    public function getWhereRaw($where, $limit = '', $page = 1, $filter = [])
    {
        $this->builder->select('*');
        $this->builder->where($this->tableName . '.deleted', 0);
        $this->builder->where($where);

        if ($limit != '') {
            $count = $this->getCount($filter);
            $offset = ($page - 1) * $limit;
            $pages = $count / $limit;
            $pages = ceil($pages);
            $pagination = $this->getPaging(
                $limit,

                $offset,
                $page,
                $pages,
                $filter
            );

            return $pagination;

            // intval($limit);
            // $this->db->limit($limit, $offset);
        }

        // if(!empty($where['customer_id'])){
        //     die($this->builder->getCompiledSelect(false));
        // }

        $query = $this->builder->get();

        return $query->getResultArray();
    }

    public function getWhere($where, $limit = '', $page = 1, $filter = [])
    {
        $this->builder->select('*');
        $this->builder->where($this->tableName . '.deleted', 0);
        $this->builder->where($where);

        if ($limit != '') {
            $count = $this->getCount($filter);

            $offset = ($page - 1) * $limit;
            $pages = $count / $limit;
            $pages = ceil($pages);
            $pagination = $this->getPaging(
                $limit,
                $offset,
                $page,
                $pages,
                $filter
            );

            return $pagination;

            // intval($limit);
            // $this->db->limit($limit, $offset);
        }

        // if(!empty($where['customer_id'])){
        //     die($this->builder->getCompiledSelect(false));
        // }

        $this->builder->orderBy($this->tableName . '.' . $this->primaryKey,'DESC');

        $query = $this->builder->get();

        return $query->getResultArray();
    }

    public function getAllWithRole($limit = '', $page = 1, $filter = [])
    {
        $this->builder->select('*, role.role AS role');
        $this->builder->from($this->tableName);
        $this->builder->join(
            'role',
            $this->tableName . '.role_id = role.role_id',
            'left'
        );
        $this->builder->where($this->tableName . '.deleted', 0);

        if ($limit != '') {
            $count = $this->getCount($filter);
            $offset = ($page - 1) * $limit;
            $pages = $count / $limit;
            $pages = ceil($pages);
            $pagination = $this->getPaging(
                $limit,
                $offset,
                $page,
                $pages,
                $filter
            );

            return $pagination;

            // intval($limit);
            // $this->db->limit($limit, $offset);
        }

        $query = $this->builder->get();
        return $query->getResultArray();
    }

    public function getWhereWithRole(
        $where,
        $limit = '',
        $page = 1,
        $filter = []
    ) {
        $this->builder->select('*, role.role AS role');
        $this->builder->from($this->tableName);
        $this->builder->join(
            'role',
            $this->tableName . '.role_id = role.role_id',
            'left'
        );
        $this->builder->where($this->tableName . '.deleted', 0);
        $this->builder->where($where);
        $query = $this->builder->get();

        if ($limit != '') {
            $count = $this->getCount($filter);
            $offset = ($page - 1) * $limit;
            $pages = $count / $limit;
            $pages = ceil($pages);
            $pagination = $this->getPaging(
                $limit,
                $offset,
                $page,
                $pages,
                $filter
            );

            return $pagination;

            // intval($limit);
            // $this->db->limit($limit, $offset);
        }

        $query = $this->builder->get();
        return $query->getResultArray();
    }


    public function insertNew($data)
    {
        $db = db_connect('default');
        $this->builder = $this->db->table($this->tableName);
        $this->builder->insert($data);
        $db_id =  $db->insertID();
        // dd($db_id);
        $this->insert_log('create', $db->insertID());
        
        return $db_id;
    }

    public function updateWhere($where, $data)
    {
        $this->builder = $this->db->table($this->tableName);
        $this->builder->where($where);
        $this->builder->update($data);
        $this->insert_where_log('update', $where);
    }
    public function softDeleteWhere($where)
    {
        $this->builder = $this->db->table($this->tableName);

        $data = [
            'deleted' => 1,
        ];
        $this->builder->where($where);
        $this->insert_where_log('soft delete where', $where);

        $this->builder->update($data);
    }

    public function softDelete($primaryKey)
    {
        $this->builder = $this->db->table($this->tableName);

        $data = [
            'deleted' => 1,
        ];

        $this->builder->where($this->primaryKey, $primaryKey);
        $this->builder->update($data);
        $this->insert_log('soft delete', $primaryKey);
    }

    public function hardDelete($primaryKey)
    {
        $this->builder = $this->db->table($this->tableName);

        $this->builder->where($this->primaryKey, $primaryKey);
        $this->insert_log('hard_delete', $primaryKey);

        $this->builder->delete();
    }

    public function get_modified_by($record){
        foreach($record as $key=> $row){
            $where = [ 
                'admin.admin_id' => $row['modified_by']
            ];
            $record[$key]['modified_by'] = $this->AdminModel->getWhere($where)[0]['username'];
        }
        
        return $record;
    }
    public function login($username, $password)
    {
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select('*');
        $this->builder->join(
            'role',
            $this->tableName . '.role_id = role.role_id',
            'left'
        );
        $this->builder->where('username = ', $username);
        $this->builder->where(
            "password = SHA2(CONCAT(salt,'" . $password . "'),512)"
        );
        $this->builder->where($this->tableName.'.deleted',0);

        $query = $this->builder->get();
        return $query->getResultArray();
    }
    public function login_customer($username, $password)
    {
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select('*');
        $this->builder->join(
            'role',
            $this->tableName . '.role_id = role.role_id',
            'left'
        );
        $this->builder->where('email = ', $username);
        $this->builder->where(
            "password = SHA2(CONCAT(salt,'" . $password . "'),512)"
        );

        $query = $this->builder->get();
        return $query->getResultArray();
    }
    public function hardDeleteWhere($where)
    {
        $this->builder = $this->db->table($this->tableName);

        $this->builder->where($where);
        $this->insert_where_log('hard_delete_where', $where);
        $this->builder->delete();
    }

    public function getWhereAndPrimaryIsNot($where, $primaryKey)
    {
        $this->builder = $this->db->table($this->tableName);
        $this->builder->select('*');
        $this->builder->where($this->primaryKey . '!=', $primaryKey);
        $this->builder->where($where);

        $query = $this->builder->get();

        return $query->getResultArray();
    }

    public function debug($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }
    public function copy($primary_id, $filter = [])
    {
        $where = [
            $this->tableName . '.' . $this->primaryKey => $primary_id,
        ];
        $data = $this->getWhereRaw($where)[0];
        if ($filter != []) {
            $data = $this->unset_array_filter($filter, $data);
        }
        unset($data[$this->primaryKey]);
        $this->insertNew($data);
    }

    // public function 
    public function getCount($filter)
    {
        $temp_builder = $this->builder;
        if (!empty($filter)) {
            foreach ($filter as $key => $row) {
                if (strpos($key, 'sort') !== false) {
                    $order_by = explode('__', $row);
                    $temp_builder->orderBy($order_by[0] . ' ' . $order_by[1]);
                } else {
                    $temp_builder->like($key, $row);
                }
            }
        }

        $this->sql = $this->builder->getCompiledSelect(false);
        $result = $this->db->query($this->sql)->getResultArray();

        // $result = $temp_builder->get()->getResultArray();

        return count($result);
    }

    public function getPaging($limit, $offset, $page, $pages, $filter)
    {
        $showing_from = $page - 2;
        $showing_to = $page + 2;

        $this->setRunningNo($offset);
        $this->builder->limit($limit, $offset);

        $result = $this->builder->get()->getResultArray();
        if ($pages == 0 or $pages == 1) {
            $pagination = '';
        } else {
            $pagination = '<nav aria-label="..." >';
            $pagination .= '<ul class="pagination">';
            if ($page > 1) {
                $pagination .= '<li class="page-item">';
                $pagination .=
                    '<a class="page-link previos" href=' .
                    strtok($_SERVER['REQUEST_URI'], '?') .
                    '?page=' .
                    ($page - 1) .
                    '  data-page="' .
                    ($page - 1) .
                    '">Previous</a>';
                $pagination .= '</li>';
            }
            if ($page == 1) {
                $pagination .=
                    '<li class="page-item active"><a class="page-link" data-page="#">1</a></li>';
            } else {
                $pagination .=
                    '<li class="page-item"><a class="page-link" href=' .
                    strtok($_SERVER['REQUEST_URI'], '?') .
                    '?page=1' .
                    ' data-page="1">1</a></li>';
            }
            if ($showing_from > 1) {
                $pagination .=
                    '<li class="page-item" disabled><span class="page-link">...</span></li>';
            }
            for ($i = 2; $i <= $pages - 1; $i++) {
                if ($i == $page) {
                    $pagination .=
                        '<li class="page-item active"><a class="page-link" data-page="#">' .
                        $i .
                        '</a></li>';
                } elseif ($i < $showing_to and $i > $showing_from) {
                    $pagination .=
                        '<li class="page-item"><a class="page-link" href=' .
                        strtok($_SERVER['REQUEST_URI'], '?') .
                        '?page=' .
                        $i .
                        ' data-page="' .
                        $i .
                        '">' .
                        $i .
                        '</a></li>';
                }
            }
            if ($showing_to < $pages) {
                $pagination .=
                    '<li class="page-item" disabled><span class="page-link">...</span></li>';
            }
            if ($page == $pages) {
                $pagination .=
                    '<li class="page-item active"><a class="page-link" data-page="#">' .
                    $pages .
                    '</a></li>';
            } else {
                $pagination .=
                    '<li class="page-item"><a class="page-link" href=' .
                    strtok($_SERVER['REQUEST_URI'], '?') .
                    '?page=' .
                    $pages .
                    '  data-page="' .
                    $pages .
                    '">' .
                    $pages .
                    '</a></li>';
            }
            if ($page < $pages) {
                $pagination .= '<li class="page-item">';
                $pagination .=
                    '<a class="page-link" href=' .
                    strtok($_SERVER['REQUEST_URI'], '?') .
                    '?page=' .
                    ($page + 1) .
                    '  data-page="' .
                    ($page + 1) .
                    '">Next</a>';
                $pagination .= '</li>';
            }
            $pagination .= '</ul>';
            $pagination .= '</nav>';
        }
        $data = [
            'result' => $result,
            'pagination' => $pagination,
            'start_no' => 1 + $offset,
        ];
        return $data;
        // $this->debug($sql);
    }

    function checkSlug($where)
    
    {
        $this->builder->select('*');
        $this->builder->from($this->tableName);
        $this->builder->where($where);
        $query = $this->builder->get();
        $existed = $query->getResultArray();
        if (!empty($existed)) {
            return true;
        } else {
            return false;
        }
    }
    function setRunningNo($index = 0)
    {
        $sql = 'SET @no = ' . $index;
        $this->db->query($sql);
    }

    // public function all_logs()
    // {
    //     // find all tables
    //     // $this->builder->select('*');

    //     $tables = $this->db->listTables();
    //     // dd($tables);
    //     foreach ($tables as $table) {
    //         // $table = 'admin';

    //     }
    // }

    public function all_logs()
    {
        // find all tables
        $tables = $this->db->listTables();

        foreach ($tables as $table) {
            // $table = 'admin';
            if (!strpos($table, '_log')) {
                $fields = $this->db->getFieldData($table);

                $table_log = $table . '_log';
                if (!$this->db->tableExists($table_log)) {
                    $this->generate_table_log($table_log, $fields);
                } else {
                    $this->update_table_log($table_log, $fields);
                }
            }
        }
    }

    public function change_title_to_name($tables = [])
    {
        // find all tables
        if ($tables == []) {
            $tables = $this->db->listTables();
        }

        foreach ($tables as $table) {
            // $table = 'admin';
            $fields = $this->db->getFieldData($table);
            $existed = false;
            foreach ($fields as $row) {
                if ($row->name == 'title') {

                    $existed = true;
                }
            }
            
            if ($existed) {
                $sql = "
                ALTER TABLE `$table` CHANGE `title` `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
                ";
                // dd($sql);
                $result = $this->db->query($sql)->getResultArray();
            }
        }
    }

    public function add_required_field($tables = [])
    {
        // find all tables
        if ($tables == []) {
            $tables = $this->db->listTables();
        }

        foreach ($tables as $table) {
            // $table = 'admin';
            $fields = $this->db->getFieldData($table);
            $existed = false;
            foreach ($fields as $row) {
                if ($row->name == 'created_by') {
                    $existed = true;
                }
            }
            if (!$existed) {
                $sql = "
                ALTER TABLE `$table`  ADD `deleted` INT NOT NULL,  ADD `modified_by` INT NOT NULL  AFTER `deleted`,  ADD `modified_date` DATE NULL  AFTER `modified_by`,  ADD `created_by` INT NOT NULL  AFTER `modified_date`,  ADD `created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP  AFTER `created_by`;
                ";
                // dd($sql);
                $result = $this->db->query($sql)->getResultArray();
            }
        }
    }

    public function get_final_form_add($filter = [])
    {
        $field = $this->get_field($filter);

        $form = $this->generate_input();
        $final_form = '';
        // dd($field);
        foreach ($field as $row) {
            $final_form .= $form[$row];
        }
        return $final_form;
    }

    public function get_final_form_edit($primary_key, $filter = [])
    {
        $field = $this->get_field($filter);
        $form = $this->generate_edit_input($primary_key);
        $final_form = '';
        // dd($field);

        foreach ($field as $row) {
            $final_form .= $form[$row];
        }
        return $final_form;
    }

    public function single_log($table)
    {
        $fields = $this->db->getFieldData($table);

        $table_log = $table . '_log';
        if (!$this->db->tableExists($table_log)) {
            $this->generate_table_log($table_log, $fields);
        } else {
            $this->update_table_log($table_log, $fields);
        }
    }

    public function reset_primary_key()
    {
        $tables = $this->db->listTables();
        foreach ($tables as $table) {
            $fields = $this->db->getFieldData($table);
            $primary_key = $table . '_id';
            if ($fields[0]->primary_key != 1) {
                $this->db->query(
                    "ALTER TABLE $table MODIFY $primary_key INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY;"
                );
            } else {
                $this->db->query(
                    "ALTER TABLE $table MODIFY $primary_key INT(10) UNSIGNED AUTO_INCREMENT;"
                );
            }
        }
    }

    public function generate_table_log($table_log, $fields)
    {
        $table_log_primary = $table_log . '_id';
        // create primary key, action and timestamp
        $this->db->query(
            "CREATE TABLE $table_log ($table_log_primary INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY);"
        );
        $this->db->query(
            "ALTER TABLE $table_log ADD COLUMN action VARCHAR(256);"
        );
        $this->db->query(
            "ALTER TABLE $table_log ADD COLUMN action_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
        );

        $fields_log = [];
        foreach ($fields as $row) {
            $name = $row->name;
            $type = strtoupper($row->type);
            $max_length =
                $row->max_length != '' ? '(' . $row->max_length . ')' : '';
            // $default = $row->default != '' ? 'DEFAULT "' . $row->default . '"' : '';
            $this->db->query(
                "ALTER TABLE $table_log ADD COLUMN $name $type$max_length"
            );
        }
    }

    public function update_table_log($table_log, $fields)
    {
        $log_fields = $this->db->getFieldData($table_log);

        foreach ($fields as $row) {
            if (!$this->in_array_field($row->name, 'name', $log_fields)) {
                $name = $row->name;
                $type = strtoupper($row->type);
                $max_length =
                    $row->max_length != '' ? '(' . $row->max_length . ')' : '';
                // $default = $row->default != '' ? 'DEFAULT "' . $row->default . '"' : '';
                $this->db->query(
                    "ALTER TABLE $table_log ADD COLUMN $name $type$max_length"
                );
            }
        }
    }

    public function in_array_field(
        $needle,
        $needle_field,
        $haystack,
        $strict = false
    ) {
        foreach ($haystack as $item) {
            if (
                isset($item->$needle_field) &&
                $item->$needle_field == $needle
            ) {
                return true;
            }
        }
        return false;
    }

    public function insert_log($action, $primary_id)
    {
        $table = $this->tableName;
        $table_id = $table . '.' . $table . '_id';
        // dd($primary_id);

        // dd("SELECT * FROM $table WHERE $table_id = $primary_id");
        $record = $this->db
            ->query("SELECT * FROM $table WHERE $table_id = $primary_id")
            ->getResultArray()[0];

        $record['action'] = $action;
        $table_log = $table . '_log';
        $builder = $this->db->table($table_log);
        $sql = $builder->set($record)->getCompiledInsert($table_log);
        // dd($sql);
        $record = $this->db->query($sql)->getResultArray();
    }

    public function convert_array_to_data($data)
    {
        array_walk($data, function (&$value, $key) {
            $value = "{$key} = '{$value}'";
        });
        $data = implode(', ', array_values($data));

        return $data;
    }

    public function convert_array_to_where($data)
    {
        array_walk($data, function (&$value, $key) {
            $value = "{$key} = '{$value}'";
        });
        $data = implode('AND ', array_values($data));

        return $data;
    }

    public function insert_where_log($action, $where)
    {
        $table = $this->tableName;
        $table_id = $table . '.' . $table . '_id';
        $where = $this->convert_array_to_where($where);
        $sql = "SELECT * FROM $table WHERE $where";
        // dd($sql);
        $record = $this->db->query($sql)->getResultArray();
        // dd($sql);
        foreach ($record as $key => $row) {
            $record[$key]['action'] = $action;
            $table_log = $table . '_log';
            // $this->db->insert($table_log, $record[$key]);
            $table_log = $table . '_log';
            $builder = $this->db->table($table_log);
            $sql = $builder->set($record[$key])->getCompiledInsert($table_log);
            // dd($sql);
            $record = $this->db->query($sql)->getResultArray();
        }
    }
}
