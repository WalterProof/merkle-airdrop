#import "./metadata.mligo" "Metadata"
#import "./errors.mligo" "Errors"

type claimed = (address, unit) big_map

type t =
  {metadata : Metadata.t;
   admin : address;
   merkle_root : bytes;
   claimed : claimed}

let assert_not_claimed (s:t) (addr : address) : unit  =
  match (Big_map.find_opt addr s.claimed) with
    | None -> ()
    | Some -> failwith Errors.already_claimed
