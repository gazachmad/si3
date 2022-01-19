<?php

namespace App\core;

class Model extends Core
{
    protected $table;

    public function get($request)
    {
        $response = $this->db->table($this->table)
            ->when(isset($request->select), function ($query) use ($request) {
                if (is_array($request->select)) {
                    $select = implode(',', $request->select);
                } else {
                    $select = $request->select;
                }
                $query->selectRaw($select);
            })
            ->when(isset($request->join), function ($query) use ($request) {
                foreach ($request->join as $key => $value) {
                    $query->join($value[0], $value[1], $value[2], $value[3]);
                }
            })
            ->when(isset($request->left_join), function ($query) use ($request) {
                foreach ($request->left_join as $key => $value) {
                    $query->leftJoin($value[0], $value[1], $value[2], $value[3]);
                }
            })
            ->when(isset($request->where), function ($query) use ($request) {
                foreach ($request->where as $key => $value) {
                    if (is_array($value)) {
                        $query->where($value[0], $value[1], $value[2]);
                    } else {
                        $query->whereRaw($value);
                    }
                }
            })
            ->when(isset($request->or_where), function ($query) use ($request) {
                foreach ($request->or_where as $key => $value) {
                    if (is_array($value)) {
                        $query->orWhere($value[0], $value[1], $value[2]);
                    } else {
                        $query->orWhereRaw($value);
                    }
                }
            })
            ->when(isset($request->where_group), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    foreach ($request->where_group as $key => $value) {
                        if (is_array($value)) {
                            $query->orWhere($value[0], $value[1], $value[2]);
                        } else {
                            $query->orWhereRaw($value);
                        }
                    }
                });
            })
            ->when(isset($request->or_where_group), function ($query) use ($request) {
                $query->orWhere(function ($query) use ($request) {
                    foreach ($request->or_where_group as $key => $value) {
                        if (is_array($value)) {
                            $query->where($value[0], $value[1], $value[2]);
                        } else {
                            $query->whereRaw($value);
                        }
                    }
                });
            })
            ->when(isset($request->order_by), function ($query) use ($request) {
                $query->orderByRaw($request->order_by);
            })
            ->when(isset($request->group_by), function ($query) use ($request) {
                $query->groupByRaw($request->group_by);
            })
            ->when(isset($request->limit), function ($query) use ($request) {
                $query->take($request->limit);
            })
            ->when(isset($request->offset), function ($query) use ($request) {
                $query->skip($request->offset);
            });

        if (isset($request->fetch_one)) {
            $response = $response->first();
        } else {
            $response = $response->get();
        }

        return $response;
    }

    public function post($request)
    {
        if (isset($request->batch)) {
            $data = [];

            foreach ($request->data as $key => $value) {
                $data[] = (array) $value;
            }

            $response = $this->db->table($this->table)->insert($data);
        } else {
            $response = $this->db->table($this->table)->insertGetId((array) $request->data);
        }

        return $response;
    }

    public function put($request)
    {
    }

    public function delete($request)
    {
    }
}
