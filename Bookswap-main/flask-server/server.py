import json
import datetime
import hashlib
from bson import json_util
from flask import Flask, request, jsonify
from flask_cors import CORS
from flask_jwt_extended import JWTManager, create_access_token, get_jwt_identity, jwt_required
from pymongo import MongoClient
from bson.objectid import ObjectId

app = Flask(__name__)
CORS(app)

# MongoDB cloud config
username = 'miltonpogi'
password = 'YwPXXNagaolerzcF'
client = MongoClient("mongodb+srv://" + username + ":" + password + "@cluster0.ifjgvho.mongodb.net/?retryWrites=true&w=majority", tls=True, tlsAllowInvalidCertificates=True)

db = client.gameswap_db
listings_collection = db.listings_collection
users_collection = db.users_collection


jwt = JWTManager(app) # initialize JWTManager
app.config['JWT_SECRET_KEY'] = 'MiltonxBOknoyxJomar'
app.config['JWT_ACCESS_TOKEN_EXPIRES'] = datetime.timedelta(days=1) # define the life span of the token

# Register API route
@app.route("/user", methods=["POST"])
def register():
    new_user = request.get_json() # store the json body request
    new_user["password"] = hashlib.sha256(new_user["password"].encode("utf-8")).hexdigest() # encrypt password
    doc = users_collection.find_one({"username": new_user["username"]}) # check if user exist
    if not doc:
        users_collection.insert_one(new_user)
        return jsonify({'msg': 'User created successfully'}), 201
    else:
        return jsonify({'msg': 'Username already exists'}), 409

# Get profile API route
@app.route("/user", methods=["GET"])
@jwt_required( )
def profile():
    current_user = get_jwt_identity() # Get the identity of the current user
    user_from_db = users_collection.find_one({'username' : current_user})
    if user_from_db:
        user_from_db['_id'] = str(user_from_db['_id'])
        del user_from_db['password'] # delete data we don't want to return
        return jsonify({'profile' : user_from_db }), 200
    else:
        return jsonify({'msg': 'Profile not found'}), 404

# Login API route
@app.route("/login", methods=["POST"])
def login():
    login_details = request.get_json() # store the json body request
    user_from_db = users_collection.find_one({'username': login_details['username']})  # search for user in database

    if user_from_db:
        encrypted_password = hashlib.sha256(login_details['password'].encode("utf-8")).hexdigest()
        if encrypted_password == user_from_db['password']:
            access_token = create_access_token(identity=user_from_db['username']) # create jwt token from username
            return jsonify(access_token=access_token), 200

    return jsonify({'msg': 'The username or password is incorrect'}), 401

# Create listing API route
@app.route("/createlisting", methods=["POST"])
@jwt_required( )
def createlisting():
    new_listing = request.get_json() # store the json body request
    new_listing["user_id"] = ObjectId(new_listing["user_id"])
    listings_collection.insert_one(new_listing)

    return jsonify({'msg': 'Listing created successfully'}), 202

@app.route("/deletelisting", methods=["GET"])
@jwt_required( )
def deletelisting():
    args = request.args
    listing_id = args.get("listing_id")
    listings_collection.delete_one({"_id": ObjectId(listing_id)})
    return jsonify({'msg': 'Listing deleted successfully'}), 203

def parse_json(data):
    return json.loads(json_util.dumps(data))

# Members API route
@app.route("/members")
def members():
    return {"members": ["Milton", "BOknoy", "Jomar"]}

# Get listings API route
# Get listings for given user_id
@app.route("/listings", methods=["GET"])
def listing():
    args = request.args
    user_id = args.get("user_id")
    return parse_json(listings_collection.find({ "user_id": ObjectId(user_id) }))

# Get listings API route
# Get listings for all users
@app.route("/alistings", methods=["GET"])
def alistings():
    # Find all listings without any user_id filter
    alistings = listings_collection.find({})
    return parse_json(alistings)

# Get listings that match (with usernames fetched from user ID)
@app.route("/searchlistings", methods=["GET"])
def searchlistings():
    args = request.args
    search_term = args.get("search_term")
    listings_collection.create_index([("title", 'text')])
    search_results = parse_json(listings_collection.find({ "$text": { "$search": search_term } }))
    for x in range(len(search_results)):
        user_id = search_results[x]["user_id"]["$oid"]
        username = parse_json(users_collection.find_one({"_id" : ObjectId(user_id)}))["username"]
        search_results[x]["username"] = username
    return search_results

# Get username from user_id
@app.route("/getusername", methods=["GET"])
def getusername():
    args = request.args
    user_id = args.get("user_id")
    return parse_json(users_collection.find_one({"_id" : ObjectId(user_id)}))
    
if __name__ == "__main__":
    app.run(debug=True)

@app.route("/editlistingform", methods=["GET", "PUT"])
@jwt_required()  # Implement JWT authentication middleware if needed
def editlistingform(listing_id):
    if request.method == "GET":
        try:
            _id = ObjectId(listing_id)
            listing = listings_collection.find_one({"_id": _id})
            if listing:
                return jsonify(listing), 200
            else:
                return jsonify({"message": "Listing not found"}), 404
        except Exception as e:
            print(f"Error fetching listing: {e}")
            return jsonify({"message": "Internal server error"}), 500

    elif request.method == "PUT":
        try:
            _id = ObjectId(listing_id)
            updated_data = request.get_json()
            update_result = listings_collection.update_one(
                {"_id": _id}, {"$set": request.get_json()} 
            )
            if update_result.matched_count == 1:
                return jsonify({"message": "Listing updated successfully!"}), 200
            else:
                return jsonify({"message": "Listing not found"}), 404
        except Exception as e:
            print(f"Error updating listing: {e}")
            return jsonify({"message": "Error updating listing"}), 500
    
@app.route("/ViewListing/<listing_id>", methods=["GET"]) 
def viewlisting(listing_id):
    try:
        # Search directly using the string ID (no ObjectId conversion)
        listing = listings_collection.find_one({"_id": listing_id}) 

        if listing:
            return jsonify(listing), 200
        else:
            return jsonify({"message": "Listing not found"}), 404

    except ValueError:  # Catch the potential error in ObjectId parsing
        return jsonify({"message": "Invalid listing ID format"}), 400

    except Exception as e:
        print(f"Error fetching listing: {e}")
        return jsonify({"message": "Internal server error"}), 500


