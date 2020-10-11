import 'dart:convert';
import 'package:flutter_crud_api_sample_app/src/model/profile.dart';
import 'package:http/http.dart' show Client;
import 'package:http/http.dart' as http;

class ApiService {
  final String baseUrl = "http://localhost/restflutter";
  Client client = Client();

  Future<List<Profile>> getProfiles() async {
    final response = await http.get("$baseUrl/api/post/read");
    if (response.statusCode == 200) {
      return profileFromJson(response.body);
    } else {
      return null;
    }
  }

  Future<bool> createProfile(Profile data) async {
    final response = await client.post(
      "$baseUrl/api/post/create",
      headers: {"content-type": "application/json"},
      body: profileToJson(data),
    );
    if (response.statusCode == 201) {
      return true;
    } else {
      return false;
    }
  }

  static List<Profile> parseUsers(String responseBody) {
    final parsed = jsonDecode(responseBody).cast<Map<String, dynamic>>();
    return parsed.map<Profile>((json) => Profile.fromJson(json)).toList();
  }

  Future<bool> updateProfile(Profile data) async {
    final response = await client.put(
      "$baseUrl/api/post/update/${data.id}",
      headers: {"content-type": "application/json"},
      body: profileToJson(data),
    );
    if (response.statusCode == 201) {
      return true;
    } else {
      return false;
    }
  }

  Future<bool> deleteProfile(String id) async {
    final response = await client.delete(
      "$baseUrl/api/post/delete/?id=$id",
      headers: {"content-type": "application/json"},
    );
    if (response.statusCode == 200) {
      return true;
    } else {
      return false;
    }
  }
}
