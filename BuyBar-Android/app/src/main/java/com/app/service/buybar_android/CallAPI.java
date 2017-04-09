package com.app.service.buybar_android;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.ClientError;
import com.android.volley.NetworkError;
import com.android.volley.NoConnectionError;
import com.android.volley.ParseError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.ServerError;
import com.android.volley.TimeoutError;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;
import java.util.Objects;

/**
 * Created by daniel on 4/9/17.
 */

final public class CallAPI {

    static public boolean getList(final Context context) {
        String requestString = "http://ec2-54-236-35-76.compute-1.amazonaws.com/api/v1/menu_items";
        final JsonArrayRequest getList = new JsonArrayRequest(Request.Method.GET, requestString, null, new Response.Listener<JSONArray>() {
            @Override
            public void onResponse(JSONArray response) {
//                //Log.v("API Key", requestType + "/getList Response: " + response.toString());
                System.out.println("Response: " + response.toString());
                try {
                    for (int i = 0; i < response.length(); i++) {

                        JSONObject jsonObject = response.getJSONObject(i);

                            int id = Integer.parseInt(jsonObject.get("id").toString());
                            String title = jsonObject.get("title").toString();
                            int price = Integer.parseInt(jsonObject.get("price").toString());

                            MainActivity.adapter.addItem(new Item(id, title, price));
                    }

                    MainActivity.applyItemList();

                } catch (JSONException jse) {}
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.v("API Key", "getUsers Err: " + error.getLocalizedMessage());

                if (error instanceof NetworkError) {
                    Toast.makeText(context, "Network Error", Toast.LENGTH_SHORT).show();
                } else if (error instanceof ClientError) {
                    Toast.makeText(context, "Client Error", Toast.LENGTH_SHORT).show();
                } else if (error instanceof ServerError) {
                    Toast.makeText(context, "Server Error", Toast.LENGTH_SHORT).show();
                } else if (error instanceof AuthFailureError) {
                    Toast.makeText(context, "Incorrect Username or Password", Toast.LENGTH_SHORT).show();
                } else if (error instanceof ParseError) {
                    Toast.makeText(context, "Parse Error", Toast.LENGTH_SHORT).show();
                } else if (error instanceof NoConnectionError) {
                    Toast.makeText(context, "No Network Connection", Toast.LENGTH_SHORT).show();
                } else if (error instanceof TimeoutError) {
                    Toast.makeText(context, "BrotherPortal could not be reached", Toast.LENGTH_SHORT).show();
                }
            }
        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                return params;
            }

            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                String userCredentials = "client_58e893bcdaa3258e893bcdaac9" + ":" + "secret_edd35b8ec98a8a4fbf9be85c34";

                String basicAuth = "Basic " + new String(Base64.encode(userCredentials.getBytes(), Base64.NO_WRAP));

                params.put("Authorization", basicAuth);

                return params;
            }
        };

        Volley.newRequestQueue(context).add(getList);
        return true;
    }

    static final public void makeOrder(final Context context, final Activity activity, final int id){

        String requestString = "http://ec2-54-236-35-76.compute-1.amazonaws.com/api/v1/orders";

        final StringRequest makeOrder = new StringRequest(Request.Method.POST, requestString, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.v("API Key", "Response: " + response.toString());
                try {
                    JSONObject resJSON = new JSONObject(response.toString());

                    Intent intent = new Intent(context, Confirmation.class);
                    String result = resJSON.getString("id").toString();
                    intent.putExtra("id", result);
                    activity.startActivity(intent);

                } catch (JSONException js) {
                    Log.e("API JSON ERROR", js.getLocalizedMessage());
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.v("API Key", "Err: " + error.getLocalizedMessage());

                if (error instanceof NetworkError) {
                    Toast.makeText(context, "Network Error", Toast.LENGTH_SHORT).show();
                } else if (error instanceof ClientError) {
                    Toast.makeText(context, "Client Error", Toast.LENGTH_SHORT).show();
                } else if (error instanceof ServerError) {
                    Toast.makeText(context, "Server Error", Toast.LENGTH_SHORT).show();
                } else if (error instanceof AuthFailureError) {
                    Toast.makeText(context, "Incorrect Username or Password", Toast.LENGTH_SHORT).show();
                } else if (error instanceof ParseError) {
                    Toast.makeText(context, "Parse Error", Toast.LENGTH_SHORT).show();
                } else if (error instanceof NoConnectionError) {
                    Toast.makeText(context, "No Network Connection", Toast.LENGTH_SHORT).show();
                } else if (error instanceof TimeoutError) {
                    Toast.makeText(context, "BrotherPortal could not be reached", Toast.LENGTH_SHORT).show();
                }
            }
        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("item", id + "");
                params.put("session", 1 + "");
                return params;
            }

            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                String userCredentials = "client_58e893bcdaa3258e893bcdaac9" + ":" + "secret_edd35b8ec98a8a4fbf9be85c34";

                String basicAuth = "Basic " + new String(Base64.encode(userCredentials.getBytes(), Base64.NO_WRAP));

                params.put("Authorization", basicAuth);

                return params;
            }
        };
        Volley.newRequestQueue(context).add(makeOrder);
    }


    ///api/v1/sessions
    public static boolean session(final Context context) {
        String requestString = "http://ec2-54-236-35-76.compute-1.amazonaws.com/api/v1/menu_items";
        final JsonArrayRequest session = new JsonArrayRequest(Request.Method.GET, requestString, null, new Response.Listener<JSONArray>() {
            @Override
            public void onResponse(JSONArray response) {
//                //Log.v("API Key", requestType + "/getList Response: " + response.toString());
                System.out.println("Response: " + response.toString());
                try {
                    for (int i = 0; i < response.length(); i++) {

                        JSONObject jsonObject = response.getJSONObject(i);

                        int id = Integer.parseInt(jsonObject.get("id").toString());
                        String title = jsonObject.get("title").toString();
                        int price = Integer.parseInt(jsonObject.get("price").toString());

                        MainActivity.adapter.addItem(new Item(id, title, price));
                    }

                    MainActivity.applyItemList();

                } catch (JSONException jse) {}
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.v("API Key", "getUsers Err: " + error.getLocalizedMessage());

                if (error instanceof NetworkError) {
                    Toast.makeText(context, "Network Error", Toast.LENGTH_SHORT).show();
                } else if (error instanceof ClientError) {
                    Toast.makeText(context, "Client Error", Toast.LENGTH_SHORT).show();
                } else if (error instanceof ServerError) {
                    Toast.makeText(context, "Server Error", Toast.LENGTH_SHORT).show();
                } else if (error instanceof AuthFailureError) {
                    Toast.makeText(context, "Incorrect Username or Password", Toast.LENGTH_SHORT).show();
                } else if (error instanceof ParseError) {
                    Toast.makeText(context, "Parse Error", Toast.LENGTH_SHORT).show();
                } else if (error instanceof NoConnectionError) {
                    Toast.makeText(context, "No Network Connection", Toast.LENGTH_SHORT).show();
                } else if (error instanceof TimeoutError) {
                    Toast.makeText(context, "BrotherPortal could not be reached", Toast.LENGTH_SHORT).show();
                }
            }
        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                return params;
            }

            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                String userCredentials = "client_58e893bcdaa3258e893bcdaac9" + ":" + "secret_edd35b8ec98a8a4fbf9be85c34";

                String basicAuth = "Basic " + new String(Base64.encode(userCredentials.getBytes(), Base64.NO_WRAP));

                params.put("Authorization", basicAuth);

                return params;
            }
        };

        Volley.newRequestQueue(context).add(session);
        return true;
    }
}
