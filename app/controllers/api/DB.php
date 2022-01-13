<?php

use App\core\Controller;
use App\models\ModelDB;

class DB extends Controller
{
    // protected function middleware()
    // {
    //     return ['jwt.auth'];
    // }

    public function query()
    {
        $request = json_decode($this->request->getContent());

        if ($this->request->isMethod(HTTP_GET)) {
            if ($request) {
                try {
                    if (!is_object($request) && count($request) > 1) {
                        $response = [];

                        foreach ($request as $key => $value) {
                            $validation = $this->validation->make((array) $value, ['alias' => 'required|string', 'table' => 'required|string'], ['required' => ':attribute is required']);

                            if ($validation->fails()) {
                                $response = implode(',', $validation->errors()->all());
                                return $this->response->json(['status' => FALSE, 'message' => $response], HTTP_BAD_REQUEST)->send();
                            }

                            $modelDB  = new ModelDB($value->table);
                            $response[$value->alias] = $modelDB->get($value);
                        }
                    } else {
                        $modelDB  = new ModelDB($request->table);
                        $response = $modelDB->get($request);
                    }

                    return $this->response->json(['status' => TRUE, 'message' => '', 'data' => $response], HTTP_OK)->send();
                } catch (\Throwable $th) {
                    if (isset($th->errorInfo)) {
                        $response = implode(',', $th->errorInfo);
                    } else {
                        $response = $th->getMessage();
                    }

                    return $this->response->json(['status' => FALSE, 'message' => $response], HTTP_BAD_REQUEST)->send();
                }
            } else {
                return $this->response->json(['status' => FALSE, 'message' => 'Unknown query'], HTTP_BAD_REQUEST)->send();
            }
        } elseif ($this->request->isMethod(HTTP_POST)) {
            if ($request) {
                $this->db->beginTransaction();

                try {
                    if (!is_object($request) && count($request) > 1) {
                        $response = [];

                        foreach ($request as $key => $value) {
                            $validation = $this->validation->make((array) $value, ['alias' => 'required|string', 'table' => 'required|string'], ['required' => ':attribute is required']);

                            if ($validation->fails()) {
                                $response = implode(',', $validation->errors()->all());

                                return $this->response->json(['status' => FALSE, 'message' => $response], HTTP_BAD_REQUEST)->send();
                            }

                            $modelDB  = new ModelDB($value->table);
                            $response[$value->alias] = $modelDB->post($value);
                        }
                    } else {
                        $modelDB  = new ModelDB($request->table);
                        $response = $modelDB->post($request);
                    }

                    $this->db->commit();

                    return $this->response->json(['status' => TRUE, 'message' => 'Data successfully created', 'data' => $response], HTTP_CREATED)->send();
                } catch (\Throwable $th) {
                    $this->db->rollback();

                    if (isset($th->errorInfo)) {
                        $response = implode(',', $th->errorInfo);
                    } else {
                        $response = $th->getMessage();
                    }

                    return $this->response->json(['status' => FALSE, 'message' => $response], HTTP_BAD_REQUEST)->send();
                }
            } else {
                return $this->response->json(['status' => FALSE, 'message' => 'Unknown query'], HTTP_BAD_REQUEST)->send();
            }
        } elseif ($this->request->isMethod(HTTP_PUT)) {
            // return $this->_queryPut();
        } elseif ($this->request->isMethod(HTTP_DELETE)) {
            // return $this->_queryDelete();
        } else {
            return $this->response->json(['status' => FALSE, 'message' => 'Unknown method'], HTTP_METHOD_NOT_ALLOWED)->send();
        }
    }

    public function raw()
    {
        $request = json_decode($this->request->getContent());

        if ($this->request->isMethod(HTTP_GET)) {
            if ($request) {
                try {
                    if (!is_object($request) && count($request) > 1) {
                        $response = [];

                        foreach ($request as $key => $value) {
                            $validation = $this->validation->make((array) $value, ['alias' => 'required|string', 'query' => 'required|string'], ['required' => ':attribute is required']);

                            if ($validation->fails()) {
                                $response = implode(',', $validation->errors()->all());

                                return $this->response->json(['status' => FALSE, 'message' => $response], HTTP_BAD_REQUEST)->send();
                            }

                            $response[$value->alias] = $this->db->select($value->query);
                        }
                    } else {
                        $response = $this->db->select($request->query);
                    }

                    return $this->response->json(['status' => TRUE, 'message' => '', 'data' => $response], HTTP_OK)->send();
                } catch (\Throwable $th) {
                    if (isset($th->errorInfo)) {
                        $response = implode(',', $th->errorInfo);
                    } else {
                        $response = $th->getMessage();
                    }

                    return $this->response->json(['status' => FALSE, 'message' => $response], HTTP_BAD_REQUEST)->send();
                }
            } else {
                return $this->response->json(['status' => FALSE, 'message' => 'Unknown query'], HTTP_BAD_REQUEST)->send();
            }
        } else {
            return $this->response->json(['status' => FALSE, 'message' => 'Unknown method'], HTTP_METHOD_NOT_ALLOWED)->send();
        }
    }
}
